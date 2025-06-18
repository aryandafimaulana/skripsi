document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const filterIndikator = document.getElementById('filterIndikator');
    const filterKondisi = document.getElementById('filterKondisi');
    const rows = document.querySelectorAll('tbody tr');

    const avg = window.dataAverages || {};

    const statusBox = document.getElementById('filterStatus');
    const searchBox = document.getElementById('searchStatus');
    const indikatorBox = document.getElementById('filterIndikatorStatus');

    function filterTable() {
        const keyword = searchInput.value.toLowerCase();
        const indikator = filterIndikator.value;
        const kondisi = filterKondisi.value;

        // Tampilkan status aktif
        if ((keyword || (indikator && kondisi)) && statusBox && searchBox && indikatorBox) {
            statusBox.classList.remove('hidden');

            searchBox.innerText = keyword ? `🔍 Pencarian: "${keyword}"` : '';
            indikatorBox.innerText = (indikator && kondisi)
                ? `🎯 Filter: ${indikator.toUpperCase()} ${kondisi === 'atas' ? '↑ Di Atas' : '↓ Di Bawah'} Rata-rata (${avg[indikator]})`
                : '';
        } else if (statusBox) {
            statusBox.classList.add('hidden');
        }

        // Filter data baris
        rows.forEach(row => {
            const provinsi = row.dataset.provinsi?.toLowerCase() || '';
            const indikatorValue = indikator ? parseFloat(row.dataset[indikator]) : null;
            const rata2 = avg[indikator];
            const cocokCari = provinsi.includes(keyword);
            let cocokFilter = true;

            if (indikator && kondisi && !isNaN(indikatorValue)) {
                cocokFilter = kondisi === 'atas' ? indikatorValue > rata2 : indikatorValue < rata2;
            }

            row.style.display = (cocokCari && cocokFilter) ? '' : 'none';
        });
    }

    // Event listener
    searchInput.addEventListener('input', filterTable);
    filterIndikator.addEventListener('change', filterTable);
    filterKondisi.addEventListener('change', filterTable);

    const resetBtn = document.getElementById('resetFilter');
    if (resetBtn) {
        resetBtn.addEventListener('click', () => {
            searchInput.value = '';
            filterIndikator.value = '';
            filterKondisi.value = '';

            if (statusBox && searchBox && indikatorBox) {
                statusBox.classList.add('hidden');
                searchBox.innerText = '';
                indikatorBox.innerText = '';
            }

            filterTable();
        });
    }

    filterTable(); // inisialisasi
});
