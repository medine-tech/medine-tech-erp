import { Toaster as Sonner } from "sonner";

type ToasterProps = React.ComponentProps<typeof Sonner>;

export function Toaster({ ...props }: ToasterProps) {
  return (
    <Sonner
      className="toaster group"
      toastOptions={{
        classNames: {
          toast:
            "group toast group-[.toaster]:bg-white group-[.toaster]:text-slate-950 group-[.toaster]:border-slate-200 group-[.toaster]:shadow-lg",
          title: "group-[.toast]:text-slate-950 text-sm font-semibold",
          description: "group-[.toast]:text-slate-500 text-sm",
          actionButton: "group-[.toast]:bg-slate-900 group-[.toast]:text-slate-50",
          cancelButton: "group-[.toast]:bg-slate-100 group-[.toast]:text-slate-500",
          error:
            "group-[.toaster]:bg-red-100 group-[.toaster]:text-red-900 group-[.toaster]:border-red-200",
          success:
            "group-[.toaster]:bg-green-100 group-[.toaster]:text-green-900 group-[.toaster]:border-green-200",
          warning:
            "group-[.toaster]:bg-amber-100 group-[.toaster]:text-amber-900 group-[.toaster]:border-amber-200",
          info: "group-[.toaster]:bg-blue-100 group-[.toaster]:text-blue-900 group-[.toaster]:border-blue-200",
        },
      }}
      {...props}
    />
  );
}
