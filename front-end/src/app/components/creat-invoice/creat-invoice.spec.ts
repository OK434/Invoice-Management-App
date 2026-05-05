import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CreatInvoice } from './creat-invoice';

describe('CreatInvoice', () => {
  let component: CreatInvoice;
  let fixture: ComponentFixture<CreatInvoice>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [CreatInvoice],
    }).compileComponents();

    fixture = TestBed.createComponent(CreatInvoice);
    component = fixture.componentInstance;
    await fixture.whenStable();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
