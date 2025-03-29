import React from "react";
import { Controller, useFormContext } from "react-hook-form";

interface FormFieldProps {
  name: string;
  label: string;
  type?: string;
  placeholder?: string;
  children?: React.ReactNode;
  description?: string;
}

export function FormField({
  name,
  label,
  type = "text",
  placeholder,
  children,
  description,
}: FormFieldProps) {
  const {
    control,
    formState: { errors },
  } = useFormContext();
  const errorMessage = errors[name]?.message as string | undefined;

  return (
    <div className="space-y-1.5 mb-4">
      <label
        htmlFor={name}
        className="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
      >
        {label}
      </label>

      {description && <p className="text-sm text-muted-foreground">{description}</p>}

      {children ? (
        <Controller
          name={name}
          control={control}
          render={({ field }) => React.cloneElement(children as React.ReactElement, { ...field })}
        />
      ) : (
        <Controller
          name={name}
          control={control}
          render={({ field }) => (
            <input
              {...field}
              id={name}
              type={type}
              placeholder={placeholder}
              className="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background 
                         file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground 
                         focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 
                         disabled:cursor-not-allowed disabled:opacity-50"
            />
          )}
        />
      )}

      {errorMessage && <p className="text-sm text-destructive">{errorMessage}</p>}
    </div>
  );
}
