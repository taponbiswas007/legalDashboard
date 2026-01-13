<table>
    <thead>
        <tr>
            <th>File Number</th>
            <th>Client Name</th>
            <th>Case Number</th>
            <th>Name of Parties</th>
            <th>Next Hearing Date</th>
            <th>Previous Date</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($cases as $case)
            <tr>
                <td>{{ $case->file_number }}</td>
                <td>{{ $case->client_name }}</td>
                <td>{{ $case->case_number }}</td>
                <td>{{ $case->name_of_parties }}</td>
                <td>{{ $case->next_hearing_date }}</td>
                <td>{{ $case->previous_date }}</td>
                <td>{{ $case->status }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
