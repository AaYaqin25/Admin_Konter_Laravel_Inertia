import React, { useEffect, useMemo, useState } from 'react';
import DataTable from '@/Components/Datatable';
import AdminLayout from '@/Layouts/AdminLayout';
import { Head, useForm } from '@inertiajs/react';
import PrimaryButton from '@/Components/PrimaryButton';
import Modal from '@/Components/Modal';
import Swal from 'sweetalert2';

const PenjualanKuota = ({ tableData, auth }) => {
    const [show, setShow] = useState(false);
    const [selectedNumberInfo, setSelectedNumberInfo] = useState(null);
    const [selectedKuotaIndex, setSelectedKuotaIndex] = useState(null);
    const [provider, setProvider] = useState(null);
    const [kuotaOptions, setKuotaOptions] = useState([]);
    const { data, setData, post, reset } = useForm({
        nomor_pelanggan: '',
        daftar_kuota_id: ''
    });

    useEffect(() => {
        const fetchKuotaOptions = async () => {
            try {
                const response = await fetch('/get-kuota-options');
                if (!response.ok) {
                    Swal.fire({
                        title: 'Gagal',
                        text: 'Gagal Fetch Data',
                        icon: 'error'
                    });
                }
                const data = await response.json();
                setKuotaOptions(data);
            } catch (error) {
                console.error('Error fetching pulsa options:', error);
            }
        };
        fetchKuotaOptions();
    }, []);

    const columns = useMemo(
        () => [
            { Header: 'Id', accessor: 'Id' },
            { Header: 'Nomor Pelanggan', accessor: 'Nomor Pelanggan' },
            { Header: 'Deskripsi Kuota', accessor: 'Deskripsi Kuota' },
            { Header: 'Provider', accessor: 'Provider' },
            { Header: 'Harga Jual', accessor: 'Harga Jual' },
            { Header: 'Harga Promo', accessor: 'Harga Promo' },
            { Header: 'Stok', accessor: 'Stok' },
            { Header: 'Tanggal Jual', accessor: 'Tanggal Jual' }
        ],
        []
    );

    const getProvider = (phoneNumber) => {
        const regex = {
            Telkomsel: /^(\\+62|\\+0|0|62)8(1[123]|51|52|53|21|22|23)[0-9]{5,9}$/,
            XL: /^(\\+62817|0817|62817|\\+0817|\\+62818|0818|62818|\\+0818|\\+62819|0819|62819|\\+0819|\\+62859|0859|62859|\\+0859|\\+0878|\\+62878|0878|62878|\\+0877|\\+62877|0877|62877)[0-9]{5,9}$/,
            Indosat: /^(\\+62815|0815|62815|\\+0815|\\+62816|0816|62816|\\+0816|\\+62858|0858|62858|\\+0814|\\+62814|0814|62814|\\+0814)[0-9]{5,9}$/,
            Tri: /^(?:\+?62|0)89\d{7,10}$/,
            AXIS: /^(?:\+?62|0)83\d{7,10}$/,
            IM3: /^(\\+62855|0855|62855|\\+0855|\\+62856|0856|62856|\\+0856|\\+62857|0857|62857|\\+0857)[0-9]{5,9}$/,
            Smartfren: /^(?:\+?62|0)88[12][0-9]{7,9}$/
        };

        for (const [provider, pattern] of Object.entries(regex)) {
            if (pattern.test(phoneNumber)) {
                return provider;
            }
        }
        return null;
    };

    const handleSelectPulsa = (index, option) => {
        setSelectedKuotaIndex(index);
        setData('daftar_kuota_id', option.id);
    };

    const handlePhoneNumberChange = (e) => {
        const phoneNumber = e.target.value;
        setData('nomor_pelanggan', phoneNumber);

        if (phoneNumber.length >= 10) {
            const matchedProvider = getProvider(phoneNumber);
            setProvider(matchedProvider);
            const info = { nomor_pelanggan: phoneNumber };
            setSelectedNumberInfo(info);
        } else {
            setProvider(null);
            setSelectedNumberInfo(null);
        }
    };

    const formatRupiah = (number) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(number);
    };

    const openModal = () => setShow(true);
    const closeModal = () => {
        reset();
        setShow(false);
        setSelectedNumberInfo(null);
        setSelectedKuotaIndex(null);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route('jual.kuota'), {
            data: {
                nomor_pelanggan: data.nomor_pelanggan,
                daftar_kuota_id: data.daftar_kuota_id
            },
            onSuccess: () => {
                Swal.fire({
                    title: 'Berhasil',
                    text: 'Penjualan kuota berhasil',
                    icon: 'success'
                });
                closeModal();
            },
            onError: (e) => {
                Swal.fire({
                    title: 'Gagal',
                    text: e.message,
                    icon: 'error'
                });
                closeModal();
            }
        });
    };

    const providerInfo = {
        Tri: "/provider/tri.jpeg",
        Telkomsel: "/provider/telkomsel.png",
        XL: "/provider/xl.png",
        Indosat: "/provider/indosat.png",
        AXIS: "/provider/axis.png",
        IM3: "/provider/im3.png",
        Smartfren: "/provider/smartfren.png"
    };

    const filteredKuotaOptions = provider ? kuotaOptions.filter(option => option.provider === provider) : kuotaOptions;
    const sortedOptions = [...filteredKuotaOptions].sort((a, b) => b.stok - a.stok);
    return (
        <AdminLayout auth={auth}>
            <Head title='Penjualan Pulsa' />
            <div className="container mx-auto p-4">
                <div className="flex justify-between items-center">
                    <h1 className="text-2xl font-semibold mb-4">Penjualan Kuota</h1>
                    <PrimaryButton onClick={openModal}>
                        Jual Kuota
                    </PrimaryButton>
                </div>
                <DataTable columns={columns} data={tableData} />
            </div>
            <Modal show={show} onClose={closeModal}>
                <h2 className="text-xl font-bold mb-4">Kuota</h2>
                <form onSubmit={handleSubmit}>
                    <div className="mb-4">
                        <label htmlFor='nomor_pelanggan' className="block text-gray-700">Nomor Pelanggan</label>
                        <input
                            type="tel"
                            value={data.nomor_pelanggan}
                            onChange={handlePhoneNumberChange}
                            className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300"
                            placeholder="Masukkan nomor pelanggan"
                            required
                            name='nomor_pelanggan'
                            id='nomor_pelanggan'
                        />
                    </div>
                    {selectedNumberInfo && provider && (
                        <div className='mb-4'>
                            <h3>Provider Pelanggan:</h3>
                            <img src={providerInfo[provider]} alt={provider} className='w-20 h-20' />
                        </div>
                    )}
                    {selectedNumberInfo && (
                        <>
                            <h3>Pilih Paket Kuota:</h3>
                            <div className="mb-4 grid grid-cols-3 gap-4">
                                {sortedOptions.map((option, index) => (
                                    <div
                                        key={option.id}
                                        role='button'
                                        className={`border p-4 mb-2 rounded overflow-x-auto flex justify-center items-center flex-col ${selectedKuotaIndex === index ? 'border-green-500' : 'border-[#D6DFEB]'} ${option.stok === 0 ? 'opacity-50 cursor-not-allowed' : ''}`}
                                        onClick={() => {
                                            if (option.stok !== 0) {
                                                handleSelectPulsa(index, option);
                                            }
                                        }}
                                    >
                                        {option.stok === 0 && (
                                            <h4 className='text-center mb-2 text-red-500'>Stok Habis</h4>
                                        )}
                                        <h4 className='text-center'>{option.deskripsi_kuota}</h4>
                                        <p>{option.harga_promo ? (
                                            <>
                                                <span className="line-through text-red-500">{formatRupiah(option.harga_kuota)}</span>
                                                <br />
                                                <span>{formatRupiah(option.harga_promo)}</span>
                                            </>
                                        ) : (
                                            formatRupiah(option.harga_kuota)
                                        )}</p>
                                    </div>
                                ))}
                            </div>
                        </>
                    )}
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

export default PenjualanKuota;
