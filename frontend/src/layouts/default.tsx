import { ReactNode } from "react";
import { Outlet } from "react-router-dom";

export default function DefaultLayout(props: { children?: ReactNode }) {
    return (
        <main className="p-4">
            {props.children}
            <Outlet />
        </main>
    );
}