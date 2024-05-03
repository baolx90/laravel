import React from 'react';
import { Route, createBrowserRouter, createRoutesFromElements } from 'react-router-dom';
import DefaultLayout from "@/layouts/default";
import Loading from "@/components/loading";
import Error404 from "@/components/error";

const HomePage = React.lazy(() => import('@/pages/home'));
const LoginPage = React.lazy(() => import('@/pages/login'));

const router = createBrowserRouter(
    createRoutesFromElements(
        <Route path="/" element={<DefaultLayout />} >
            <Route index element={
                    <React.Suspense fallback={<Loading />}>
                        <HomePage />
                    </React.Suspense>
                }
            />
            <Route path="/login" element={
                    <React.Suspense fallback={<Loading />}>
                        <LoginPage />
                    </React.Suspense>
                }
            />
            <Route path="*" element={<Error404 />} />
        </Route>
    )
);

export default router;
