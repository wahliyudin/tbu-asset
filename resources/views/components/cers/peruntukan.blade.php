<table class="w-100">
    <tbody>
        @foreach (\App\Enums\Cers\Peruntukan::cases() as $peruntukan)
            <tr>
                <td class="fs-6 fw-semibold">{{ $loop->iteration == 1 ? 'Peruntukan' : '' }}</td>
                <td>{{ $loop->iteration == 1 ? ':' : '' }}</td>
                <td>
                    <div class="form-check form-check-custom">
                        <input class="form-check-input" @disabled($type == 'show') @checked(isset($cer->peruntukan) ? $cer->peruntukan == $peruntukan : $loop->iteration == 1)
                            name="peruntukan" type="radio" value="{{ $peruntukan }}" id="{{ $peruntukan }}" />
                        <label class="form-check-label fs-6 fw-semibold text-black" for="{{ $peruntukan }}">
                            {{ $peruntukan->label() }}
                        </label>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
