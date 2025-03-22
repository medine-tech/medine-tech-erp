import { z } from "zod";

export const loginSchema = z.object({
  email: z
    .string()
    .min(1, { message: "El correo electrónico es requerido" })
    .email({ message: "Correo electrónico inválido" }),
  password: z
    .string()
    .min(1, { message: "La contraseña es requerida" })
    .min(6, { message: "La contraseña debe tener al menos 6 caracteres" }),
  rememberMe: z.boolean().optional().default(false),
});

export type LoginFormValues = z.infer<typeof loginSchema>;

export const registerSchema = z
  .object({
    name: z
      .string()
      .min(1, { message: "El nombre es requerido" })
      .max(100, { message: "El nombre no puede exceder los 100 caracteres" }),
    email: z
      .string()
      .min(1, { message: "El correo electrónico es requerido" })
      .email({ message: "Correo electrónico inválido" }),
    password: z
      .string()
      .min(1, { message: "La contraseña es requerida" })
      .min(8, { message: "La contraseña debe tener al menos 8 caracteres" }),
    confirmPassword: z.string().min(1, { message: "La confirmación de contraseña es requerida" }),
    termsAccepted: z
      .boolean()
      .refine((val) => val, { message: "Debes aceptar los términos y condiciones" }),
  })
  .refine((data) => data.password === data.confirmPassword, {
    message: "Las contraseñas no coinciden",
    path: ["confirmPassword"],
  });

export const firstCompanySchema = z
  .object({
    companyId: z.string().uuid({ message: "El ID de la compañía debe ser un UUID válido" }),
    companyName: z
      .string()
      .min(3, { message: "El nombre de la compañía debe tener al menos 3 caracteres" })
      .max(100, { message: "El nombre de la compañía no puede exceder los 100 caracteres" }),
    name: z
      .string()
      .min(3, { message: "El nombre debe tener al menos 3 caracteres" })
      .max(100, { message: "El nombre no puede exceder los 100 caracteres" }),
    email: z.string().email({ message: "Por favor, ingresa un correo electrónico válido" }),
    password: z.string().min(8, { message: "La contraseña debe tener al menos 8 caracteres" }),
    password_confirmation: z
      .string()
      .min(8, { message: "La confirmación de contraseña debe tener al menos 8 caracteres" }),
  })
  .refine((data) => data.password === data.password_confirmation, {
    message: "Las contraseñas no coinciden",
    path: ["password_confirmation"],
  });

export type RegisterFormValues = z.infer<typeof registerSchema>;
export type FirstCompanyFormValues = z.infer<typeof firstCompanySchema>;
