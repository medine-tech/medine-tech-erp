import React from 'react';
import { useForm, FormProvider, UseFormProps, FieldValues, SubmitHandler } from 'react-hook-form';
import { zodResolver } from '@hookform/resolvers/zod';
import { z } from 'zod';

interface FormProps<T extends FieldValues> {
  schema: z.ZodType<T>;
  defaultValues?: Partial<T>;
  onSubmit: SubmitHandler<T>;
  children: React.ReactNode;
  formOptions?: Omit<UseFormProps<T>, 'resolver'>;
  className?: string;
}

export function Form<T extends FieldValues>({
  schema,
  defaultValues,
  onSubmit,
  children,
  formOptions,
  className,
}: FormProps<T>) {
  const methods = useForm<T>({
    resolver: zodResolver(schema),
    defaultValues,
    ...formOptions,
  });

  return (
    <FormProvider {...methods}>
      <form
        onSubmit={methods.handleSubmit(onSubmit)}
        className={className}
        noValidate
      >
        {children}
      </form>
    </FormProvider>
  );
}
