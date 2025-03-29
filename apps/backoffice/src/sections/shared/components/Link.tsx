import { Link as TanStackLink } from "@tanstack/react-router";
import { ComponentProps, forwardRef } from "react";

type LinkProps = ComponentProps<typeof TanStackLink>;

export const Link = forwardRef<HTMLAnchorElement, LinkProps>((props, ref) => {
  return <TanStackLink {...props} ref={ref} />;
});

Link.displayName = "Link";
