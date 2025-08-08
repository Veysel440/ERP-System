import "./globals.css";
import Providers from "./providers";

export const metadata = { title: "ERP" };

export default function RootLayout({ children }: { children: React.ReactNode }) {
    return (
        <html lang="tr">
        <body>
        <Providers>{children}</Providers>
        </body>
        </html>
    );
}
