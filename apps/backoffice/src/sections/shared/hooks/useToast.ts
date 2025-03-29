import { toast } from "sonner";

type ToastType = {
  title?: string;
  description: string;
  variant?: "default" | "destructive";
};

export function useToast() {
  const showToast = ({ title, description, variant = "default" }: ToastType) => {
    if (variant === "destructive") {
      toast.error(description, {
        id: title,
      });
    } else {
      toast.success(description, {
        id: title,
      });
    }
  };

  return {
    toast: showToast,
  };
}
