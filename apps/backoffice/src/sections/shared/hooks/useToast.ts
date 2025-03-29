import { toast } from "sonner";

type ToastType = {
  title?: string;
  description: string;
  variant?: "default" | "destructive";
};

export function useToast(): {
  toast: (props: ToastType) => void;
  dismiss: (toastId?: string) => void;
} {
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

  const dismissToast = (toastId?: string) => {
    if (toastId) {
      toast.dismiss(toastId);
    } else {
      toast.dismiss();
    }
  };

  return {
    toast: showToast,
    dismiss: dismissToast,
  };
}
