<table class="w-100">
    <tbody>
        @foreach (\App\Enums\Cers\TypeBudget::cases() as $typeBudget)
            <tr>
                <td class="fs-6 fw-semibold">{{ $loop->iteration == 1 ? 'Status' : '' }}</td>
                <td>{{ $loop->iteration == 1 ? ':' : '' }}</td>
                <td>
                    <div class="form-check form-check-custom">
                        <input class="form-check-input" @disabled($type == 'show') @checked(isset($cer->type_budget) ? $cer->type_budget == $typeBudget : $loop->iteration == 1)
                            name="type_budget" type="radio" value="{{ $typeBudget }}" id="{{ $typeBudget }}" />
                        <label class="form-check-label fs-6 fw-semibold" for="{{ $typeBudget }}">
                            {{ $typeBudget->label() }}
                        </label>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
