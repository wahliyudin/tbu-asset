<div class="d-flex align-items-center justify-content-evenly w-100">
    @foreach (\App\Enums\Cers\SumberPendanaan::cases() as $sumberPendanaan)
        <div class="form-check form-check-custom">
            <input class="form-check-input" @checked(isset($cer->sumber_pendanaan) ? $cer->sumber_pendanaan : $loop->iteration == 1) name="sumber_pendanaan" type="radio"
                value="{{ $sumberPendanaan }}" id="{{ $sumberPendanaan }}" />
            <label class="form-check-label fs-6 fw-semibold" for="{{ $sumberPendanaan }}">
                {{ $sumberPendanaan->label() }}
            </label>
        </div>
    @endforeach
</div>
