<div class="col-md-12 d-flex justify-content-center">
    <table class="text-center">
        <tbody>
            <tr>
                @foreach ($workflows as $workflow)
                    <td style="width: 155px; {{ $workflow->sequence == 1 ? 'border-top-left-radius: 10px' : ($workflow->sequence == count($workflows) ? 'border-top-right-radius: 10px;' : '') }};"
                        class="{{ $workflow->last_action == \App\Enums\Workflows\LastAction::APPROV ? 'bg-success' : ($workflow->last_action == \App\Enums\Workflows\LastAction::REJECT ? 'bg-danger' : 'bg-warning') }} text-white px-3 fs-6 fw-semibold {{ $workflow->sequence != 1 ? 'border-start' : '' }}">
                        {{ $workflow->title }}
                        By</td>
                @endforeach
            </tr>
            <tr>
                @foreach ($workflows as $workflow)
                    <td style="width: 155px; vertical-align: top;"
                        class="{{ $workflow->last_action == \App\Enums\Workflows\LastAction::APPROV ? 'bg-success' : ($workflow->last_action == \App\Enums\Workflows\LastAction::REJECT ? 'bg-danger' : 'bg-warning') }} text-white px-3 {{ $workflow->sequence != 1 ? 'border-start' : '' }}">
                        {{ $workflow?->employee?->nama_karyawan }}</td>
                @endforeach
            </tr>
            <tr class="border-top">
                @foreach ($workflows as $workflow)
                    <td style="width: 155px;"
                        class="{{ $workflow->last_action == \App\Enums\Workflows\LastAction::APPROV ? 'bg-success' : ($workflow->last_action == \App\Enums\Workflows\LastAction::REJECT ? 'bg-danger' : 'bg-warning') }} text-white px-3 fs-6 fw-semibold {{ $workflow->sequence != 1 ? 'border-start' : '' }}">
                        {{ $workflow->title }}
                        On</td>
                @endforeach
            </tr>
            <tr>
                @foreach ($workflows as $workflow)
                    <td style="width: 155px; {{ $workflow->sequence == 1 ? 'border-bottom-left-radius: 10px' : ($workflow->sequence == count($workflows) ? 'border-bottom-right-radius: 10px;' : '') }};"
                        class="{{ $workflow->last_action == \App\Enums\Workflows\LastAction::APPROV ? 'bg-success' : ($workflow->last_action == \App\Enums\Workflows\LastAction::REJECT ? 'bg-danger' : 'bg-warning') }} text-white px-3 {{ $workflow->sequence != 1 ? 'border-start' : '' }}">
                        {{ $workflow->last_action == \App\Enums\Workflows\LastAction::APPROV ? $workflow?->last_action_date : '-' }}
                    </td>
                @endforeach
            </tr>
        </tbody>
    </table>
</div>
