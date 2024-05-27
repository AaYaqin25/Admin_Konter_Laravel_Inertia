import React from 'react';
import { useTable, usePagination, useSortBy, useGlobalFilter } from 'react-table';
import { CSVLink } from 'react-csv';
import jsPDF from 'jspdf';
import html2canvas from 'html2canvas';
import dayjs from 'dayjs';
import 'dayjs/locale/id';
dayjs.locale('id')

const DataTable = ({ columns, data }) => {
    const {
        getTableProps,
        getTableBodyProps,
        headerGroups,
        page,
        nextPage,
        previousPage,
        canNextPage,
        canPreviousPage,
        pageOptions,
        state,
        gotoPage,
        pageCount,
        setPageSize,
        prepareRow,
        setGlobalFilter,
    } = useTable(
        {
            columns,
            data,
            initialState: { pageIndex: 0 },
        },
        useGlobalFilter,
        useSortBy,
        usePagination
    );

    const { globalFilter, pageIndex, pageSize } = state;

    const exportToPDF = () => {
        const input = document.getElementById('table');
        html2canvas(input).then((canvas) => {
            const imgData = canvas.toDataURL('image/png');
            const pdf = new jsPDF('landscape', 'pt', 'a4');
            pdf.addImage(imgData, 'PNG', 0, 0);
            pdf.save('table.pdf');
        });
    };

    const formatRupiah = (number) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(number);
    }

    const formatPulsa = (number) => {
        return new Intl.NumberFormat('id-ID', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
            useGrouping: true
        }).format(number);
    };

    return (
        <div>
            <input
                value={globalFilter || ''}
                onChange={(e) => setGlobalFilter(e.target.value)}
                placeholder="Search"
                className="mb-4 p-2 border rounded"
            />
            <table {...getTableProps()} className="min-w-full leading-normal" id="table">
                <thead>
                    {headerGroups.map((headerGroup, index,) => (
                        <tr {...headerGroup.getHeaderGroupProps()} key={index}>
                            {headerGroup.headers.map((column, ind) => (
                                <th
                                    {...column.getHeaderProps(column.getSortByToggleProps())}
                                    className="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider"
                                    key={ind}
                                >
                                    {column.render('Header')}
                                    <span>
                                        {column.isSorted ? (column.isSortedDesc ? ' ▼' : ' ▲') : ''}
                                    </span>
                                </th>
                            ))}
                        </tr>
                    ))}
                </thead>
                <tbody {...getTableBodyProps()}>
                    {page.map((row, index) => {
                        prepareRow(row);
                        return (
                            <tr {...row.getRowProps()} key={index}>
                                {row.cells.map((cell, index) => (
                                    <td
                                        {...cell.getCellProps()}
                                        className="px-5 py-5 border-b border-gray-200 bg-white text-sm"
                                        key={index}
                                    >
                                        {cell.column.id === 'Tanggal Beli' || cell.column.id === 'Tanggal Jual' ? (
                                            cell.value ? dayjs(cell.value).format('dddd, DD MMMM YYYY HH:mm:ss') : null
                                        ) : cell.column.id === 'Pulsa' ? formatPulsa(cell.value) :
                                            cell.column.id === 'Harga Jual' ||
                                            cell.column.id === 'Saldo Dibeli' ||
                                            cell.column.id === 'Jumlah Saldo' ||
                                            cell.column.id === 'Harga Promo' && cell.value !== '-' ?
                                                formatRupiah(cell.value)
                                                : (
                                                    cell.render('Cell')
                                                )}
                                    </td>
                                ))}
                            </tr>
                        );
                    })}
                </tbody>
            </table>
            <div className="flex justify-between mt-4">
                <div>
                    <button onClick={() => previousPage()} disabled={!canPreviousPage} className={`px-4 py-2 bg-gray-200 text-gray-800 rounded ${!canPreviousPage && 'cursor-not-allowed opacity-40'}`}>
                        Previous
                    </button>
                    <button onClick={() => nextPage()} disabled={!canNextPage} className={`px-4 py-2 bg-gray-200 text-gray-800 rounded ml-2 ${!canNextPage && 'cursor-not-allowed opacity-40'}`}>
                        Next
                    </button>
                </div>
                <div>
                    Page{' '}
                    <strong>
                        {pageIndex + 1} of {pageOptions.length}
                    </strong>
                </div>
                <div>
                    <select
                        value={pageSize}
                        onChange={(e) => setPageSize(Number(e.target.value))}
                        className="p-2 border rounded"
                    >
                        {[10, 20, 30, 40, 50].map((pageSize) => (
                            <option key={pageSize} value={pageSize}>
                                Show {pageSize}
                            </option>
                        ))}
                    </select>
                </div>
            </div>
            <div className="flex justify-between mt-4">
                <CSVLink data={data} className="px-4 py-2 bg-green-500 text-white rounded">
                    Export CSV
                </CSVLink>
                <button onClick={exportToPDF} className="px-4 py-2 bg-red-500 text-white rounded">
                    Export PDF
                </button>
            </div>
        </div>
    );
};

export default DataTable;
