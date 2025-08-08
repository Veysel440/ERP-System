"use client";
type Props = React.ButtonHTMLAttributes<HTMLButtonElement>;

const cn = (...c:(string|false|undefined)[]) => c.filter(Boolean).join(" ");

export default function Button({ className, ...p }: Props) {
    return <button className={cn("px-4 py-2 rounded bg-black text-white disabled:opacity-50", className)} {...p} />;
}
