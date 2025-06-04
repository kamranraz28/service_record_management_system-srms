<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <title>অফিসভিত্তিক এন্ট্রি রিপোর্ট</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali&display=swap');

        body {
            font-family: 'Noto Sans Bengali', sans-serif;
            background: #f9f9f9;
            color: #333;
            margin: 40px;
        }

        center {
            margin-bottom: 30px;
        }

        h1 {
            color: #006625;
            font-weight: 700;
            font-size: 2.4rem;
            margin-bottom: 0.2rem;
            text-align: center;
        }

        h3 {
            font-weight: 600;
            font-size: 1.5rem;
            margin: 0;
            text-align: center;
            color: #004d1a;
        }

        p.report-date {
            margin-top: 8px;
            font-weight: 600;
            font-size: 1rem;
            color: #006625;
            text-align: center;
            letter-spacing: 0.03em;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 4px 10px rgb(0 0 0 / 0.1);
            border-radius: 8px;
            overflow: hidden;
            font-size: 1rem;
            min-width: 600px;
        }

        thead tr {
            background: #006625;
            color: #ffffff;
            font-weight: 700;
            text-transform: uppercase;
        }

        th, td {
            padding: 12px 18px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        th:nth-child(2), td:nth-child(2) {
            text-align: left;
        }

        tbody tr:hover {
            background-color: #f1f9f5;
            transition: background-color 0.3s ease;
        }

        .forest-state-row {
            background-color: #dff0d8;
            font-weight: 700;
            color: #2d572c;
        }

        .division-row td:nth-child(2) {
            padding-left: 40px;
            font-weight: 500;
            color: #4b6f44;
        }

        .footer {
            background-color: #e6f2e6;
            font-weight: 700;
            font-size: 1.1rem;
            color: #2d572c;
        }

        @media (max-width: 768px) {
            body {
                margin: 20px 10px;
            }
            table {
                font-size: 0.9rem;
                min-width: 100%;
            }
            .division-row td:nth-child(2) {
                padding-left: 25px;
            }
        }
    </style>
</head>
<body>
    <center>
        <h1>বন অধিদপ্তর-গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</h1>
        <h3>অফিসভিত্তিক এন্ট্রি রিপোর্ট</h3>
        <p class="report-date">রিপোর্ট তৈরির তারিখ: {{ englishToBanglaNumber(\Carbon\Carbon::now()->isoFormat('D MMMM, Y')) }}</p>
    </center>

    <table>
        <thead>
            <tr>
                <th style="color: #ffffff;">ক্রমিক নং</th>
                <th style="color: #ffffff;">অফিসের নাম</th>
                <th style="color: #ffffff;">এন্ট্রির সংখ্যা</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($reportList as $index => $report)
                @php $total += $report->count; @endphp
                @if ($report->type === 'forest_state')
                    <tr class="forest-state-row">
                        <td>{{ englishToBanglaNumber($index + 1) }}</td>
                        <td>{{ $report->office }}</td>
                        <td>{{ englishToBanglaNumber($report->count) }}</td>
                    </tr>
                @else
                    <tr class="division-row">
                        <td>{{ englishToBanglaNumber($index + 1) }}</td>
                        <td>{{ $report->office }}</td>
                        <td>{{ englishToBanglaNumber($report->count) }}</td>
                    </tr>
                @endif
            @endforeach
            <tr class="footer">
                <td colspan="2" style="text-align: right;">সর্বমোট</td>
                <td>{{ englishToBanglaNumber($total) }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
