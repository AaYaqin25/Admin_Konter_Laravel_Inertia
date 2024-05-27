import React from 'react';
import { Head } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';
import { Line } from 'react-chartjs-2';
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

export default function Dashboard({ auth, penjualanKuota, penjualanPulsa, keuntunganKuota, keuntunganPulsa, totalKeuntungan, kuotaPerBulan, pulsaPerBulan }) {
    const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

    const kuotaData = {
        labels: months,
        datasets: [
            {
                label: 'Penjualan Kuota',
                data: months.map((_, index) => kuotaPerBulan[index + 1] || 0),
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                fill: true,
            }
        ],
    };

    const pulsaData = {
        labels: months,
        datasets: [
            {
                label: 'Penjualan Pulsa',
                data: months.map((_, index) => pulsaPerBulan[index + 1] || 0),
                borderColor: 'rgba(153, 102, 255, 1)',
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                fill: true,
            }
        ],
    };

    const formatRupiah = (number) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(number);
    }

    return (
        <AdminLayout auth={auth}>
            <Head title="Dashboard" />
            <div className="p-4">
                <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div className="bg-blue-500 text-white rounded-lg shadow p-6">
                        <h3 className="text-xl font-semibold">Penjualan Kuota</h3>
                        <p className="mt-4 text-3xl">{formatRupiah(penjualanKuota)}</p>
                    </div>
                    <div className="bg-green-500 text-white rounded-lg shadow p-6">
                        <h3 className="text-xl font-semibold">Penjualan Pulsa</h3>
                        <p className="mt-4 text-3xl">{formatRupiah(penjualanPulsa)}</p>
                    </div>
                    <div className="bg-yellow-500 text-white rounded-lg shadow p-6">
                        <h3 className="text-xl font-semibold">Keuntungan Kuota</h3>
                        <p className="mt-4 text-3xl">{formatRupiah(keuntunganKuota)}</p>
                    </div>
                    <div className="bg-red-500 text-white rounded-lg shadow p-6">
                        <h3 className="text-xl font-semibold">Keuntungan Pulsa</h3>
                        <p className="mt-4 text-3xl">{formatRupiah(keuntunganPulsa)}</p>
                    </div>
                    <div className="bg-purple-500 text-white rounded-lg shadow p-6">
                        <h3 className="text-xl font-semibold">Total Keuntungan</h3>
                        <p className="mt-4 text-3xl">{formatRupiah(totalKeuntungan)}</p>
                    </div>

                </div>
                <div className='flex flex-row gap-4 mt-4'>
                    <div className="bg-purple-500 text-white rounded-lg shadow p-6 w-1/2">
                        <h3 className="text-xl font-semibold">Penjualan Bulanan Kuota</h3>
                        <Line data={kuotaData} />
                    </div>
                    <div className="bg-yellow-500 text-white rounded-lg shadow p-6 w-1/2">
                        <h3 className="text-xl font-semibold">Penjualan Bulanan Pulsa</h3>
                        <Line data={pulsaData} />
                    </div>
                </div>
            </div>
        </AdminLayout>
    );
}
