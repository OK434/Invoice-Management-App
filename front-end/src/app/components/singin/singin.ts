import { Component, signal } from '@angular/core';
import {
  FormBuilder,
  FormGroup,
  FormsModule,
  ReactiveFormsModule,
  Validators,
} from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { Api } from '../../services/api';
import { Router } from '@angular/router';
import { NgIf } from '@angular/common';

@Component({
  selector: 'app-singin',
  imports: [ReactiveFormsModule, HttpClientModule, FormsModule, NgIf],
  templateUrl: './singin.html',
  styleUrl: './singin.css',
  standalone: true,
})
export class Singin {
  form!: FormGroup;
  errorMessage = signal('');
  constructor(
    private fb: FormBuilder,
    private api: Api,
    private router: Router,
  ) {}

  ngOnInit() {
    this.form = this.fb.group({
      clientName: ['', Validators.required],
      email: ['', [Validators.required, Validators.email]],
      password: ['', [Validators.required, Validators.minLength(8)]],
      confirmPassword: ['', Validators.required],
      companyName: ['', Validators.required],
      addressName: ['', Validators.required],
    });
  }

  signIn() {
    console.log('clicked');

    if (this.form.invalid) return;

    const { confirmPassword, ...rest } = this.form.value;

    if (this.form.value.password !== confirmPassword) {
      console.log('Passwords do not match');
      return;
    }

    const data = {
      ...rest,
      password_confirmation: confirmPassword,
    };

    this.api.register(data).subscribe({
      next: (res) => {
        console.log('SUCCESS:', res);
        this.router.navigate(['']);
      },
      error: (err) => {
        console.log('ERROR:', err.error);
        this.errorMessage.set(err.error?.message || 'Something went wrong');
      },
    });
  }
  logIn() {
    this.router.navigate(['']);
  }
}
