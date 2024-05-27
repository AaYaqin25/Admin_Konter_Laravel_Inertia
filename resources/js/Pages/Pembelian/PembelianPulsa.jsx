// resources/js/Pages/PembelianPulsa.jsx
import React, { useState, useMemo } from 'react';
import DataTable from '@/Components/Datatable';
import AdminLayout from '@/Layouts/AdminLayout';
import { Head, useForm } from '@inertiajs/react';
import PrimaryButton from '@/Components/PrimaryButton';
import Modal from '@/Components/Modal';
import Swal from 'sweetalert2';

const PembelianPulsa = ({ tableData, auth }) => {
    const [show, setShow] = useState(false);
    const { data, setData, post, reset } = useForm({
        jumlah: '',
    });

    const columns = useMemo(
        () => [
            {
                Header: 'Id',
                accessor: 'Id'
            },
            {
                Header: "Saldo Dibeli",
                accessor: "Saldo Dibeli"
            },
            {
                Header: 'Jumlah Saldo',
                accessor: 'Jumlah Saldo',
            },
            {
                Header: 'Tanggal Beli',
                accessor: 'Tanggal Beli'
            }
        ],
        []
    );

    const openModal = () => setShow(true);
    const closeModal = () => {
        reset();
        setShow(false);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route('saldo.beli'), {
            onSuccess: () => {
                Swal.fire({
                    title: 'Berhasil',
                    text: 'Pembelian saldo berhasil',
                    icon: 'success'
                })
                closeModal()
            },
            onError: () => {
                Swal.fire({
                    title: 'Gagal',
                    text: 'Pembelian saldo gagal',
                    icon: 'error'
                })
                closeModal()
            }
        });
    };

    return (
        <AdminLayout auth={auth}>
            <Head title="Pembelian Pulsa" />
            <div className="container mx-auto p-4">
                <div className="flex justify-between items-center">
                    <h1 className="text-2xl font-semibold mb-4">Pembelian Saldo</h1>
                    <PrimaryButton onClick={openModal}>
                        Beli Saldo
                    </PrimaryButton>
                </div>
                <DataTable columns={columns} data={tableData} />
            </div>
            <Modal show={show} onClose={closeModal}>
                <h2 className="text-xl font-bold mb-4">Beli Saldo</h2>
                <form onSubmit={handleSubmit}>
                    <div className="mb-4">
                        <label className="block text-gray-700">Jumlah</label>
                        <input
                            type="number"
                            value={data.jumlah}
                            onChange={(e) => setData('jumlah', e.target.value)}
                            className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300"
                            placeholder="Masukkan jumlah saldo"
                            required
                            name='jumlah'
                            id='jumlah'
                        />
                    </div>
                    <div className="flex justify-end">
                        <button
                            type="submit"
                            className="px-4 py-2 bg-blue-500 text-white rounded mr-2"
                        >
                            Submit
                        </button>
                        <button
                            type="button"
                            className="px-4 py-2 bg-gray-300 text-gray-700 rounded"
                            onClick={closeModal}
                        >
                            Cancel
                        </button>
                    </div>
                </form>
            </Modal>
        </AdminLayout>
    );
};

export default PembelianPulsa;
