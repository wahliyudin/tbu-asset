<!DOCTYPE html>
<html>

<head>
    <title>TBU</title>
</head>

<body>
    <div class="greeting" style="margin-bottom : 20px">
        <span>
            <strong>Dear Dept Finace,</strong>
        </span>
    </div>
    <div class="body">
        Budget planning with the costcode below has been moved from {{ $transfer->oldProject?->project }} to
        {{ $transfer->newProject?->project }} :
        <br>
        <table>
            <thead>
                <tr>
                    <th>Costcode</th>
                    <th>Description</th>
                    <th>Remaining</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($histories as $history)
                    <tr>
                        <td>{{ $history['budgetcode'] }}</td>
                        <td>{{ $history['description_budget'] }}</td>
                        <td>{{ number_format($history['remaining_budget']) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div><br>

    <div class="thanks" style="margin-top:20px">
        <span>
            Best Regards,<br><strong>ASSET Alert System</strong>
        </span>
    </div>
</body>

</html>
