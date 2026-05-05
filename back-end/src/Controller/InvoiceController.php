<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Invoice;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/invoice')]
class InvoiceController
{
    public function __construct()
    {

    }

    #[Route('/create', name: 'create_invoice', methods: ['POST'])]
    public function createInvoice(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$data || !isset($data['client_id'], $data['items'])) {
            return new JsonResponse(['message' => 'Invalid data'], 400);
        }

        $client = $em->getRepository(\App\Entity\Client::class)->find($data['client_id']);

        if (!$client) {
            return new JsonResponse(['message' => 'Client not found'], 404);
        }

        $total = 0;

        foreach ($data['items'] as $item) {

            if (!isset($item['description'], $item['quantity'], $item['price'])) {
                return new JsonResponse(['message' => 'Invalid item data'], 400);
            }

            $invoice = new Invoice();

            $invoice->setDescription($item['description']);
            $invoice->setInvoiceQuantity($item['quantity']);
            $invoice->setInvoicePrice($item['price']);
            $invoice->setDate(new \DateTime());
            $itemTotal = $item['quantity'] * $item['price'];
            $invoice->setInvoiceTotal($itemTotal);

            $invoice->setClient($client);

            $total += $itemTotal;

            $em->persist($invoice);
        }

        $em->flush();

        return new JsonResponse([
            'message' => 'Invoice created successfully',
            'total' => $total
        ], 201);
    }

    #[Route('', name: 'api_invoice', methods: ['GET'])]
    public function getInvoice(EntityManagerInterface $em): JsonResponse
    {
        $invoices = $em->getRepository(Invoice::class)->findAll();

        $data = [];

        foreach ($invoices as $invoice) {
            $client = $invoice->getClient();

            $data[] = [
                'id' => $invoice->getId(),

                'client' => [
                    'id' => $client->getId(),
                    'name' => $client->getClientName(),
                    'email' => $client->getEmail(),
                ],

                'invoiceQuantity' => $invoice->getInvoiceQuantity(),
                'description' => $invoice->getDescription(),
                'invoicePrice' => $invoice->getInvoicePrice(),
                'invoiceTotal' => $invoice->getInvoiceTotal(),
                'date' => $invoice->getDate()?->format('Y-m-d H:i:s')
            ];
        }

        return new JsonResponse($data, 200);
    }

    #[Route('/import', name: "import", methods: ['POST'])]
    public function import(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $file = $request->files->get('file');

        if (!$file) {
            return new JsonResponse(['error' => 'No file uploaded'], 400);
        }

        $handle = fopen($file->getPathname(), 'r');

        if (!$handle) {
            return new JsonResponse(['error' => 'Cannot open file'], 400);
        }

        $created = 0;
        $failed = [];
        $rowNumber = 0;

        while (($row = fgetcsv($handle, 1000, ',')) !== false) {
            $rowNumber++;

            // skip header
            if ($rowNumber === 1) continue;

            try {
                $clientName = $row[0] ?? null;
                $description = $row[1] ?? null;
                $quantity = isset($row[2]) ? (int)$row[2] : 0;
                $price = isset($row[3]) ? (int)$row[3] : 0;
                $dateString = $row[4] ?? null;

                // ✅ validation
                if (!$clientName || !$description || $quantity <= 0 || $price <= 0) {
                    throw new \Exception('Invalid data');
                }

                // ✅ find client
                $client = $em->getRepository(\App\Entity\Client::class)
                    ->findOneBy(['clientName' => $clientName]);

                if (!$client) {
                    throw new \Exception("Client '{$clientName}' not found");
                }


                // ✅ parse date
                try {
                    $date = $dateString
                        ? new \DateTime($dateString)
                        : new \DateTime();
                } catch (\Exception $e) {
                    throw new \Exception('Invalid date format');
                }

                // ✅ calculate total
                $total = $quantity * $price;
                $client_id = $client->getId();
                // ✅ create invoice
                $invoice = new Invoice();
                $invoice->setClient($client);
                $invoice->setDescription($description);
                $invoice->setInvoiceQuantity($quantity);
                $invoice->setInvoicePrice($price);
                $invoice->setInvoiceTotal($total);
                $invoice->setDate($date);

                $em->persist($invoice);

                $created++;

            } catch (\Exception $e) {
                $failed[] = [
                    'row' => $rowNumber,
                    'error' => $e->getMessage()
                ];
            }
        }

        fclose($handle);
        $em->flush();

        return new JsonResponse([
            'created' => $created,
            'failed' => $failed
        ]);
    }
}
