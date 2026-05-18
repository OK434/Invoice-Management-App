import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ImportInvoice } from './import-invoice';

describe('ImportInvoice', () => {
  let component: ImportInvoice;
  let fixture: ComponentFixture<ImportInvoice>;
  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ImportInvoice],
    }).compileComponents();

    fixture = TestBed.createComponent(ImportInvoice);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
