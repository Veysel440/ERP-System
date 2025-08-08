"use client";
type Props = React.InputHTMLAttributes<HTMLInputElement>;
export default function Input(p:Props){ return <input className="w-full px-3 py-2 border rounded" {...p}/> }
