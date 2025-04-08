import { Component,OnInit } from '@angular/core';
import { FormBuilder, FormGroup,ReactiveFormsModule,Validators } from '@angular/forms';

import { Router } from '@angular/router';
import { ToastrService } from 'ngx-toastr';
import { AuthService } from '../../services/auth.service';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-signup',
  imports: [
    CommonModule,
    ReactiveFormsModule
  ],
  templateUrl: './signup.component.html',
  styleUrl: './signup.component.css'
})
export class SignupComponent implements OnInit {
  signupForm!: FormGroup;
  currentStep: number = 1;
  stepTitle: string = 'Créer un Compte';
  constructor(
    private fb: FormBuilder,
    private authService: AuthService,
    private router: Router,
    private toastr: ToastrService
  ) {}

  ngOnInit(): void {
    this.signupForm = this.fb.group({
      email: ['', [Validators.required, Validators.email]],
      name: ['', [Validators.required]],
      phone: [''],
      password: ['', [Validators.required,Validators.minLength(6)]],
      confirmPassword: ['',[Validators.required]]
    }, { validator: this.passwordMatchValidator})
  }

  passwordMatchValidator(group: FormGroup) {
    const password = group.get('password')?.value;
    const confirmPassword = group.get('confirmPassword')?.value;
    return password === confirmPassword ? null : { mismatch: true };
  }

  nextStep(): void {
    if (this.currentStep < 3 ) {
      if(!this.isCurrentStepValid()) {
        this.toastr.error('Please fill in the required fields');
        return;
      }
      this.currentStep++;
      this.updateStepTitle();
    } else {
        if (this.signupForm.valid) {
          this.registerUser();
        } else {
            this.toastr.error('Please correct the errors');
        }
    }
  }

  updateStepTitle() {
    this.stepTitle = [
      'Création du compte',
      'Informations générales',
      'Ecriture du mot de passe',
    ][this.currentStep - 1];
  }

  isCurrentStepValid() {
    const controlsToCheck = {
      1: ['email'],
      2: ['name'],
      3: ['password', 'confirmPassword']
    }[this.currentStep];

    return controlsToCheck?.every((control) => this.signupForm.get(control)?.valid);
  }

  registerUser(): void {
    const formData = this.signupForm.value;
    this.authService.register({
      email: formData.email,
      name: formData.name,
      password: formData.password,
      password_confirmation: formData.confirmPassword
    }).subscribe({
      next: () => {
        this.toastr.success('Registration Successful!');
        this.router.navigate(['/login']);
      },
      error: (err) => {
        console.error(err);
        this.toastr.error('Registration Failed!!!')
      }
    })
  }
}
