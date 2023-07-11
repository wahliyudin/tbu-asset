<div class="d-flex flex-grow-1 align-items-center justify-content-evenly">
    @foreach (\App\Enums\Disposes\Dispose\Pelaksanaan::cases() as $pelaksanaan)
        <div class="form-check form-check-custom">
            <input class="form-check-input" @disabled($type == 'show') @checked(isset($assetDispose->pelaksanaan) ? $assetDispose->pelaksanaan == $pelaksanaan : $loop->iteration == 1) name="pelaksanaan"
                type="radio" value="{{ $pelaksanaan }}" id="{{ $pelaksanaan }}" />
            <label class="form-check-label fs-6 fw-semibold text-black" for="{{ $pelaksanaan }}">
                {{ $pelaksanaan->label() }}
            </label>
        </div>
    @endforeach
</div>
