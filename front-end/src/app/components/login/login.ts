import { Component, signal } from '@angular/core';
import { FormBuilder, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { Api } from '../../services/api';
import { Router } from '@angular/router';
import { NgIf } from '@angular/common';
@Component({
  selector: 'app-login',
  imports: [ReactiveFormsModule, HttpClientModule, NgIf],
  templateUrl: './login.html',
  styleUrl: './login.css',
  standalone: true,
})
export class Login {
  form!: FormGroup;
  constructor(
    private fb: FormBuilder,
    private api: Api,
    private router: Router,
  ) {}
  errorMessage = signal('');
  ngOnInit() {
    this.form = this.fb.group({
      email: ['', Validators.required],
      password: ['', Validators.minLength(8)],
    });
  }
  login() {
    if (this.form.invalid) return;
    this.api.login(this.form.value).subscribe({
      next: (res: any) => {
        localStorage.setItem('token', res.token);

        console.log('SUCCESS:', res);

        this.router.navigate(['/home']);

      },
      error: (err) => {
        console.log('ERROR:', err.error);
        this.errorMessage.set(err.error?.message || 'Something went wrong');
      },
    });
  }
  singIn() {
    this.router.navigate(['/singin']);
  }
}
