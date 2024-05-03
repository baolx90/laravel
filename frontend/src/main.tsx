import React from 'react'
import ReactDOM from 'react-dom/client'
import App from './App.tsx'
import { RouterProvider } from 'react-router-dom';
import {AuthContext} from '@/contexts/auth'
import router from "./router";

ReactDOM.createRoot(document.getElementById('root')!).render(
  <React.StrictMode>
    <AuthContext>
      <RouterProvider router={router} />
    </AuthContext>
  </React.StrictMode>,
)
