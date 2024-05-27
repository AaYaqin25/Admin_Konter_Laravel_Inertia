// resources/js/Layouts/AdminLayout.jsx
import React from 'react';
import Sidebar from '@/Components/Sidebar';
import { usePage } from '@inertiajs/react';

const AdminLayout = ({ children, auth }) => {
    const { saldo } = usePage().props;
    return (
        <div className="flex">
            <Sidebar auth={auth} saldo={saldo} />
            <div className="flex-grow">
                <div className="bg-gray-100 min-h-screen p-4">
                    {children}
                </div>
            </div>
        </div>
    );
};

export default AdminLayout;
