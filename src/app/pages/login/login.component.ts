import { Component,OnInit } from '@angular/core';
import { FormBuilder, FormGroup,ReactiveFormsModule,Validators } from '@angular/forms';

import { Router } from '@angular/router';
import { ToastrService } from 'ngx-toastr';
import { AuthService } from '../../services/auth.service';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-login',
  imports: [
    CommonModule,
    ReactiveFormsModule
  ],
  templateUrl: './login.component.html',
  styleUrl: './login.component.css'
})
export class LoginComponent implements OnInit {
    loginForm!: FormGroup;
    isLoading: boolean = false;

    constructor(
      private fb: FormBuilder,
      private authService: AuthService,
      private router: Router,
      private toastr: ToastrService

    ) {}

    ngOnInit(): void {
      this.loginForm = this.fb.group({
        email: ['',[Validators.required, Validators.email]],
        password: ['',[Validators.required]],
      })
    }

    onSubmit(): void {
      if(this.loginForm.invalid) {
        this.toastr.error('Please fill in the required fields correctly');
        return;
      }

      this.isLoading = true;
      const credentials = this.loginForm.value;

      this.authService.login(credentials).subscribe({
        next: (response) => {
          localStorage.setItem('auth_token', response.token);
          this.toastr.success('Login successful!');
          this.router.navigate(['/dashboard']);
        },
        error: (err) => {
          console.error(err);
          this.toastr.error('Login Failed. Please check your credentials.');
        },
        complete: ()  => {
          this.isLoading = false;
        }
      })
    }
}
