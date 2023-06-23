<div class="row align-items-center">
    <div class="col-md-3">
        <img src="{{ asset('assets/media/logos/tbu.png') }}" style="width: 100%;" alt="">
    </div>
    <div class="col-md-6">
        <div class="d-flex flex-column">
            <h5 class="fw-bold text-center" style="text-transform: uppercase;">tbu
                management
                system</h5>
            <h6 class="fw-bold text-center" style="text-transform: uppercase;">formulir <br>
                {{ $title }}
            </h6>
        </div>
    </div>
    <div class="col-md-3">
        <table>
            <tbody>
                <tr>
                    <td class="py-0" style="font-size: 14px;">Nomor</td>
                    <td class="py-0 px-2">:</td>
                    <td class="py-0" style="font-size: 14px; white-space: nowrap;">
                        {{ $nomor }}</td>
                </tr>
                <tr>
                    <td class="py-0" style="font-size: 14px; white-space: nowrap;">Tanggal
                        Terbit</td>
                    <td class="py-0 px-2">:</td>
                    <td class="py-0" style="font-size: 14px;">{{ $tanggal }}</td>
                </tr>
                <tr>
                    <td class="py-0" style="font-size: 14px;">Revisi</td>
                    <td class="py-0 px-2">:</td>
                    <td class="py-0" style="font-size: 14px;">{{ $revisi }}</td>
                </tr>
                <tr>
                    <td class="py-0" style="font-size: 14px;">Halaman</td>
                    <td class="py-0 px-2">:</td>
                    <td class="py-0" style="font-size: 14px;">{{ $halaman }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
