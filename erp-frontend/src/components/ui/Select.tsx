"use client";
type Opt = { value:string|number; label:string };
export default function Select(
    { options, ...p }:{ options: Opt[] } & React.SelectHTMLAttributes<HTMLSelectElement>
){
    return (
        <select className="w-full px-3 py-2 border rounded" {...p}>
            <option value="">Seçiniz</option>
            {options.map(o=>(<option key={o.value} value={o.value}>{o.label}</option>))}
        </select>
    );
}
