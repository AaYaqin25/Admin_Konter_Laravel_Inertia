// resources/js/Components/Sidebar.jsx
import React, { useState } from 'react';
import { Link, useForm } from '@inertiajs/react';
import Modal from './Modal';
import InputLabel from './InputLabel';
import TextInput from './TextInput';
import InputError from './InputError';
import Swal from 'sweetalert2';

const Sidebar = ({ auth, saldo }) => {
    const [showModal, setShowModal] = useState(false);
    const [selectedImage, setSelectedImage] = useState(null);
    const [newImage, setNewImage] = useState(null);
    const { data, setData, post, errors, setError } = useForm({
        file_foto: null,
    });

    const formatRupiah = (number) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(number);
    };

    const handleImageClick = (image) => {
        setSelectedImage(image);
        setShowModal(true);
    };

    const handleSubmit = (e) => {
        e.preventDefault();

        post(route('profile.picture.update'), {
            data: data.file_foto,
            onSuccess: () => {
                Swal.fire({
                    title: 'Berhasil',
                    text: 'Pergantian foto profile berhasil',
                    icon: 'success'
                });
                setShowModal(false);
            },
        });
    };

    const handleCancel = () => {
        setNewImage(null);
        setData('file_foto', null);
        setShowModal(false);
        setError('file_foto', null)
    };

    return (
        <aside className="w-64 bg-gray-800 text-white flex flex-col min-h-screen">
            <div className="flex items-center justify-center h-16 bg-gray-900">
                <span className="text-lg font-semibold">Admin Dashboard</span>
            </div>
            <div className="flex-grow">
                <div className="flex items-center p-4 bg-gray-900"
                    onClick={() => handleImageClick(`${auth.user.file_foto ? `/uploads/${auth.user.file_foto}` : 'https://via.placeholder.com/40'}`)}>
                    {auth.user.file_foto ?
                        <img src={`/uploads/${auth.user.file_foto}`} alt=" " className='h-10 w-10 rounded-full cursor-pointer' />
                        :
                        <img
                            className="h-10 w-10 rounded-full cursor-pointer"
                            src="https://via.placeholder.com/40"
                            alt="User Avatar"
                        />
                    }
                    <span className="ml-4">{auth.user.name}</span>
                </div>
                <div className="p-4 bg-gray-900 flex items-center">
                    <span className="block text-sm">Saldo: {formatRupiah(saldo)}</span>
                </div>
                <nav className="mt-2">
                    <ul >
                        <li>
                            <Link
                                href="/"
                                className="block px-4 py-4 hover:bg-gray-700 hover:text-white"
                            >
                                Dashboard
                            </Link>
                        </li>
                        <li>
                            <Link
                                href="/profile"
                                className="block px-4 py-4 hover:bg-gray-700 hover:text-white"
                            >
                                Profile
                            </Link>
                        </li>
                        <li>
                            <Link
                                href="/penjualan-kuota"
                                className="block px-4 py-4 hover:bg-gray-700 hover:text-white"
                            >
                                Penjualan Kuota
                            </Link>
                        </li>
                        <li>
                            <Link
                                href="/penjualan-pulsa"
                                className="block px-4 py-4 hover:bg-gray-700 hover:text-white"
                            >
                                Penjualan Pulsa
                            </Link>
                        </li>
                        <li>
                            <Link
                                href="/pembelian-saldo"
                                className="block px-4 py-4 hover:bg-gray-700 hover:text-white"
                            >
                                Pembelian Saldo
                            </Link>
                        </li>
                        <li>
                            <Link
                                href="/logout"
                                className="block px-4 py-4 hover:bg-gray-700 hover:text-white"
                                method="post"
                                as='button'
                            >
                                Logout
                            </Link>
                        </li>
                    </ul>
                </nav>
            </div>
            <Modal show={showModal} onClose={() => setShowModal(false)}>
                <div className="flex flex-col items-center justify-center">
                    {newImage ? (
                        <img src={newImage} alt="User Avatar" className="size-1/2" />
                    ) : (
                        <img src={selectedImage} alt="User Avatar" className="size-1/2" />
                    )}
                    <form className="mt-4" onSubmit={handleSubmit}>
                        <div className="mt-4">
                            <InputLabel htmlFor="file_foto" value="Upload Foto" />

                            <TextInput
                                id="file_foto"
                                type="file"
                                name="file_foto"
                                className="relative m-0 block w-full min-w-0 flex-auto cursor-pointer rounded border border-solid border-secondary-500 bg-transparent bg-clip-padding px-3 py-[0.32rem] text-base font-normal text-surface transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:me-3 file:cursor-pointer file:overflow-hidden file:rounded-none file:border-0 file:border-e file:border-solid file:border-inherit file:bg-transparent file:px-3  file:py-[0.32rem] file:text-surface focus:border-primary focus:text-gray-700 focus:shadow-inset focus:outline-none dark:border-white/70 dark:text-white  file:dark:text-white"
                                onChange={(e) => {
                                    setNewImage(URL.createObjectURL(e.target.files[0]));
                                    setData('file_foto', e.target.files[0]);
                                }}
                            />

                            <InputError className="mt-2" message={errors.file_foto} />
                        </div>
                        <div className="flex justify-center mt-4">
                            <button
                                type="submit"
                                className="bg-blue-500 text-white py-2 px-4 mr-2 rounded hover:bg-blue-600"
                            >
                                Submit
                            </button>
                            <button
                                type="button"
                                onClick={handleCancel}
                                className="bg-gray-300 text-gray-700 py-2 px-4 rounded hover:bg-gray-400"
                            >
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </Modal>
        </aside>
    );
};

export default Sidebar;
