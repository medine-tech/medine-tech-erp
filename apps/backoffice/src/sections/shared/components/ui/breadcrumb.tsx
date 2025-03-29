import { Link } from "@tanstack/react-router";
import { ChevronRight } from "lucide-react";
import * as React from "react";

import { cn } from "../../lib/utils";

interface BreadcrumbProps extends React.ComponentProps<"nav"> {
  segments: {
    label: string;
    href?: string;
  }[];
  separator?: React.ReactNode;
  className?: string;
}

export function Breadcrumb({
  segments,
  separator = <ChevronRight className="h-4 w-4 text-muted-foreground" />,
  className,
  ...props
}: BreadcrumbProps) {
  return (
    <nav aria-label="Breadcrumb" className={cn("flex items-center text-sm", className)} {...props}>
      <ol className="flex items-center gap-1.5">
        {segments.map((segment, index) => {
          const isLastItem = index === segments.length - 1;

          return (
            <li key={index} className="flex items-center gap-1.5">
              {segment.href && !isLastItem ? (
                <Link
                  to={segment.href}
                  className="text-muted-foreground hover:text-foreground transition-colors"
                >
                  {segment.label}
                </Link>
              ) : (
                <span className={isLastItem ? "font-medium" : "text-muted-foreground"}>
                  {segment.label}
                </span>
              )}
              {!isLastItem && separator}
            </li>
          );
        })}
      </ol>
    </nav>
  );
}
