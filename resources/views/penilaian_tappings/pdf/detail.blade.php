<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail Nilai Agent - Peak {{ $peak }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }
        .footer {
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding: 4px 0 2px 0;
            margin-top: 8px;
            word-break: break-word;
        }
        .section {
            margin-bottom: 25px;
        }
        .parameter-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        /* Hapus min-height dan style tidak perlu */
        .info-section {
            margin-bottom: 25px;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }
        .info-row {
            display: flex;
            margin-bottom: 8px;
        }
        .info-label {
            font-weight: bold;
            width: 150px;
            color: #333;
        }
        .info-value {
            color: #555;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            background-color: #007bff;
            color: white;
            padding: 8px 12px;
            margin: 0 0 15px 0;
            font-weight: bold;
            border-radius: 3px;
        }
        .parameter-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .parameter-table th,
        .parameter-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .parameter-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .parameter-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .category-row {
            background-color: #e3f2fd !important;
            font-weight: bold;
        }
        .sub-parameter {
            background-color: #ffffff !important;
            font-size: 11px;
        }
        .total-row {
            background-color: #c8e6c9 !important;
            font-weight: bold;
            border-top: 2px solid #4caf50;
        }
        .status {
            padding: 5px 10px;
            border-radius: 3px;
            font-weight: bold;
            text-align: center;
        }
        .status.lulus {
            background-color: #d4edda;
            color: #155724;
        }
        .status.tidak-lulus {
            background-color: #f8d7da;
            color: #721c24;
        }

        
        @media print {
            body {
                margin: 0;
                padding: 15px;
            }
            .header {
                page-break-after: avoid;
            }
            /* .section dan .parameter-table biarkan default agar bisa dibagi otomatis oleh PDF engine */
            .footer {
                margin-top: 8px;
                padding-bottom: 0;
                background: #fff;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>DETAIL PENILAIAN AGENT</h1>
        <h2>Peak {{ $peak }} - {{ date('d F Y') }}</h2>
    </div>

    <div class="info-section">
        <div class="info-row">
            <div class="info-label">Nama Agent:</div>
            <div class="info-value">{{ $penilaian->user->name ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Perner:</div>
            <div class="info-value">{{ $penilaian->perner ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Login ID:</div>
            <div class="info-value">{{ $penilaian->login_id ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Site:</div>
            <div class="info-value">{{ $penilaian->site ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Peak:</div>
            <div class="info-value">{{ $penilaian->peak ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Tanggal Recording:</div>
            <div class="info-value">{{ $penilaian->tanggal_recording ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Nama Checker:</div>
            <div class="info-value">{{ $penilaian->nama_checker ?? 'N/A' }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Total QM:</div>
            <div class="info-value">{{ $penilaian->total_qm_p1 ?? 0 }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Status:</div>
            <div class="info-value">
                <span class="status {{ strtolower($penilaian->keterangan) == 'lulus' ? 'lulus' : 'tidak-lulus' }}">
                    {{ $penilaian->keterangan ?? 'N/A' }}
                </span>
            </div>
        </div>
    </div>

    <div class="section">
        <h3 class="section-title">PARAMETER PROSES</h3>
        <table class="parameter-table">
            <thead>
                <tr>
                    <th>Parameter</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                <tr class="category-row">
                    <td><strong>Menyampaikan salam pembuka</strong></td>
                    <td><strong>{{ $detailNilai['proses']['pembuka']['total'] }}</strong></td>
                </tr>
                <tr class="sub-parameter">
                    <td>&nbsp;&nbsp;• Salam pembuka diucapkan tidak jelas dan benar</td>
                    <td>{{ $detailNilai['proses']['pembuka']['n1_1'] == 1 ? '1' : '0' }}</td>
                </tr>
                <tr class="sub-parameter">
                    <td>&nbsp;&nbsp;• Opening diucapkan dengan tidak benar (Ex:119 PSC Kota Bandung, dengan (nama agent) ada yang bisa dibantu?)</td>
                    <td>{{ $detailNilai['proses']['pembuka']['n1_2'] == 1 ? '1' : '0' }}</td>
                </tr>
                <tr class="sub-parameter">
                    <td>&nbsp;&nbsp;• Salam pembuka dan Opening tidak diucapkan dengan intonasi ramah, dan terdengar sedang tersenyum</td>
                    <td>{{ $detailNilai['proses']['pembuka']['n1_3'] == 1 ? '1' : '0' }}</td>
                </tr>
                <tr class="sub-parameter">
                    <td>&nbsp;&nbsp;• Salam pembuka diucapkan > 3 detik</td>
                    <td>{{ $detailNilai['proses']['pembuka']['n1_4'] == 1 ? '1' : '0' }}</td>
                </tr>
                <tr class="sub-parameter">
                    <td>&nbsp;&nbsp;• Salam pembuka dan Opening diucapkan terdengar tersendat-sendat, ragu-ragu atau diralat</td>
                    <td>{{ $detailNilai['proses']['pembuka']['n1_5'] == 1 ? '1' : '0' }}</td>
                </tr>
                
                <tr class="category-row">
                    <td><strong>Melakukan verifikasi data pelanggan</strong></td>
                    <td><strong>{{ $detailNilai['proses']['verifikasi']['total'] }}</strong></td>
                </tr>
                <tr class="sub-parameter">
                    <td>&nbsp;&nbsp;• Melakukan verifikasi data pelanggan</td>
                    <td>{{ $detailNilai['proses']['verifikasi']['n2_1'] == 1 ? '1' : '0' }}</td>
                </tr>
                <tr class="sub-parameter">
                    <td>&nbsp;&nbsp;• Verifikasi data pelanggan tidak dilakukan dengan lengkap</td>
                    <td>{{ $detailNilai['proses']['verifikasi']['n2_2'] == 1 ? '1' : '0' }}</td>
                </tr>
                
                <tr class="category-row">
                    <td><strong>Menyampaikan salam penutup</strong></td>
                    <td><strong>{{ $detailNilai['proses']['penutup']['total'] }}</strong></td>
                </tr>
                <tr class="sub-parameter">
                    <td>&nbsp;&nbsp;• Salam penutup diucapkan tidak jelas dan benar</td>
                    <td>{{ $detailNilai['proses']['penutup']['n3_1'] == 1 ? '1' : '0' }}</td>
                </tr>
                <tr class="sub-parameter">
                    <td>&nbsp;&nbsp;• Tidak memutus (release) Closing ketika pelanggan memutus hubungan telepon (Maksimal pada detik ke-3, apabila pelanggan belum memutuskan hubungan telepon)</td>
                    <td>{{ $detailNilai['proses']['penutup']['n3_2'] == 1 ? '1' : '0' }}</td>
                </tr>
                
                <tr class="total-row">
                    <td><strong>TOTAL PROSES</strong></td>
                    <td><strong>{{ $detailNilai['proses']['total'] }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="section">
        <h3 class="section-title">PARAMETER SIKAP</h3>
        <table class="parameter-table">
            <thead>
                <tr>
                    <th>Parameter</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($parameterSikap as $sikap)
                    <tr class="category-row">
                        <td><b>{{ $sikap->header_p1 }}</b></td>
                        <td><b>{{ $detailNilai['sikap']['p1']['total'] }}</b></td>
                    </tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_1_1 }}</td><td>{{ $detailNilai['sikap']['p1']['n4_1'] == 1 ? '1' : '0' }}</td></tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_1_2 }}</td><td>{{ $detailNilai['sikap']['p1']['n4_2'] == 1 ? '1' : '0' }}</td></tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_1_3 }}</td><td>{{ $detailNilai['sikap']['p1']['n4_3'] == 1 ? '1' : '0' }}</td></tr>

                    <tr class="category-row">
                        <td><b>{{ $sikap->header_p2 }}</b></td>
                        <td><b>{{ $detailNilai['sikap']['p2']['total'] }}</b></td>
                    </tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_2_1 }}</td><td>{{ $detailNilai['sikap']['p2']['n5_1'] == 1 ? '1' : '0' }}</td></tr>

                    <tr class="category-row">
                        <td><b>{{ $sikap->header_p3 }}</b></td>
                        <td><b>{{ $detailNilai['sikap']['p3']['total'] }}</b></td>
                    </tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_3_1 }}</td><td>{{ $detailNilai['sikap']['p3']['n6_1'] == 1 ? '1' : '0' }}</td></tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_3_2 }}</td><td>{{ $detailNilai['sikap']['p3']['n6_2'] == 1 ? '1' : '0' }}</td></tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_3_3 }}</td><td>{{ $detailNilai['sikap']['p3']['n6_3'] == 1 ? '1' : '0' }}</td></tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_3_4 }}</td><td>{{ $detailNilai['sikap']['p3']['n6_4'] == 1 ? '1' : '0' }}</td></tr>

                    <tr class="category-row">
                        <td><b>{{ $sikap->header_p4 }}</b></td>
                        <td><b>{{ $detailNilai['sikap']['p4']['total'] }}</b></td>
                    </tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_4_1 }}</td><td>{{ $detailNilai['sikap']['p4']['n7_1'] == 1 ? '1' : '0' }}</td></tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_4_2 }}</td><td>{{ $detailNilai['sikap']['p4']['n7_2'] == 1 ? '1' : '0' }}</td></tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_4_3 }}</td><td>{{ $detailNilai['sikap']['p4']['n7_3'] == 1 ? '1' : '0' }}</td></tr>

                    <tr class="category-row">
                        <td><b>{{ $sikap->header_p5 }}</b></td>
                        <td><b>{{ $detailNilai['sikap']['p5']['total'] }}</b></td>
                    </tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_5_1 }}</td><td>{{ $detailNilai['sikap']['p5']['n8_1'] == 1 ? '1' : '0' }}</td></tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_5_2 }}</td><td>{{ $detailNilai['sikap']['p5']['n8_2'] == 1 ? '1' : '0' }}</td></tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_5_3 }}</td><td>{{ $detailNilai['sikap']['p5']['n8_3'] == 1 ? '1' : '0' }}</td></tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_5_4 }}</td><td>{{ $detailNilai['sikap']['p5']['n8_4'] == 1 ? '1' : '0' }}</td></tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_5_5 }}</td><td>{{ $detailNilai['sikap']['p5']['n8_5'] == 1 ? '1' : '0' }}</td></tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_5_6 }}</td><td>{{ $detailNilai['sikap']['p5']['n8_6'] == 1 ? '1' : '0' }}</td></tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_5_7 }}</td><td>{{ $detailNilai['sikap']['p5']['n8_7'] == 1 ? '1' : '0' }}</td></tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_5_8 }}</td><td>{{ $detailNilai['sikap']['p5']['n8_8'] == 1 ? '1' : '0' }}</td></tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_5_9 }}</td><td>{{ $detailNilai['sikap']['p5']['n8_9'] == 1 ? '1' : '0' }}</td></tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_5_10 }}</td><td>{{ $detailNilai['sikap']['p5']['n8_10'] == 1 ? '1' : '0' }}</td></tr>

                    <tr class="category-row">
                        <td><b>{{ $sikap->header_p6 }}</b></td>
                        <td><b>{{ $detailNilai['sikap']['p6']['total'] }}</b></td>
                    </tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_6_1 }}</td><td>{{ $detailNilai['sikap']['p6']['n9_1'] == 1 ? '1' : '0' }}</td></tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_6_2 }}</td><td>{{ $detailNilai['sikap']['p6']['n9_2'] == 1 ? '1' : '0' }}</td></tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_6_3 }}</td><td>{{ $detailNilai['sikap']['p6']['n9_3'] == 1 ? '1' : '0' }}</td></tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_6_4 }}</td><td>{{ $detailNilai['sikap']['p6']['n9_4'] == 1 ? '1' : '0' }}</td></tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_6_5 }}</td><td>{{ $detailNilai['sikap']['p6']['n9_5'] == 1 ? '1' : '0' }}</td></tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_6_6 }}</td><td>{{ $detailNilai['sikap']['p6']['n9_6'] == 1 ? '1' : '0' }}</td></tr>

                    <tr class="category-row">
                        <td><b>{{ $sikap->header_p7 }}</b></td>
                        <td><b>{{ $detailNilai['sikap']['p7']['total'] }}</b></td>
                    </tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_7_1 }}</td><td>{{ $detailNilai['sikap']['p7']['n10_1'] == 1 ? '1' : '0' }}</td></tr>

                    <tr class="category-row">
                        <td><b>{{ $sikap->header_p8 }}</b></td>
                        <td><b>{{ $detailNilai['sikap']['p8']['total'] }}</b></td>
                    </tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_8_1 }}</td><td>{{ $detailNilai['sikap']['p8']['n11_1'] == 1 ? '1' : '0' }}</td></tr>

                    <tr class="category-row">
                        <td><b>{{ $sikap->header_p9 }}</b></td>
                        <td><b>{{ $detailNilai['sikap']['p9']['total'] }}</b></td>
                    </tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_9_1 }}</td><td>{{ $detailNilai['sikap']['p9']['n12_1'] == 1 ? '1' : '0' }}</td></tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_9_2 }}</td><td>{{ $detailNilai['sikap']['p9']['n12_2'] == 1 ? '1' : '0' }}</td></tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_9_3 }}</td><td>{{ $detailNilai['sikap']['p9']['n12_3'] == 1 ? '1' : '0' }}</td></tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_9_4 }}</td><td>{{ $detailNilai['sikap']['p9']['n12_4'] == 1 ? '1' : '0' }}</td></tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_9_5 }}</td><td>{{ $detailNilai['sikap']['p9']['n12_5'] == 1 ? '1' : '0' }}</td></tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_9_6 }}</td><td>{{ $detailNilai['sikap']['p9']['n12_6'] == 1 ? '1' : '0' }}</td></tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_9_7 }}</td><td>{{ $detailNilai['sikap']['p9']['n12_7'] == 1 ? '1' : '0' }}</td></tr>

                    <tr class="category-row">
                        <td><b>{{ $sikap->header_p10 }}</b></td>
                        <td><b>{{ $detailNilai['sikap']['p10']['total'] }}</b></td>
                    </tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_10_1 }}</td><td>{{ $detailNilai['sikap']['p10']['n13_1'] == 1 ? '1' : '0' }}</td></tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_10_2 }}</td><td>{{ $detailNilai['sikap']['p10']['n13_2'] == 1 ? '1' : '0' }}</td></tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_10_3 }}</td><td>{{ $detailNilai['sikap']['p10']['n13_3'] == 1 ? '1' : '0' }}</td></tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_10_4 }}</td><td>{{ $detailNilai['sikap']['p10']['n13_4'] == 1 ? '1' : '0' }}</td></tr>

                    <tr class="category-row">
                        <td><b>{{ $sikap->header_p11 }}</b></td>
                        <td><b>{{ $detailNilai['sikap']['p11']['total'] }}</b></td>
                    </tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_11_1 }}</td><td>{{ $detailNilai['sikap']['p11']['n14_1'] == 1 ? '1' : '0' }}</td></tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_11_2 }}</td><td>{{ $detailNilai['sikap']['p11']['n14_2'] == 1 ? '1' : '0' }}</td></tr>
                    <tr class="sub-parameter"><td>{{ $sikap->detail_11_3 }}</td><td>{{ $detailNilai['sikap']['p11']['n14_3'] == 1 ? '1' : '0' }}</td></tr>
                @endforeach
                <tr class="total-row">
                    <td><strong>TOTAL NILAI PARAMETER SIKAP</strong></td>
                    <td><strong>{{ $detailNilai['sikap']['total'] }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="section">
        <h3 class="section-title">PARAMETER SOLUSI</h3>
        <table class="parameter-table">
            <thead>
                <tr>
                    <th>Parameter</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($parameterSolusi as $solusi)
                    <tr class="category-row">
                        <td><strong>{{ $solusi->header_p1 }}</strong></td>
                        <td><strong>{{ $detailNilai['solusi']['p1']['total'] }}</strong></td>
                    </tr>
                    <tr class="sub-parameter">
                        <td>{{ $solusi->detail_p1 }}</td>
                        <td>{{ $detailNilai['solusi']['p1']['n15_1'] == 1 ? '1' : '0' }}</td>
                    </tr>
                    <tr class="category-row">
                        <td><strong>{{ $solusi->header_p2 }}</strong></td>
                        <td><strong>{{ $detailNilai['solusi']['p2']['total'] }}</strong></td>
                    </tr>
                    <tr class="sub-parameter">
                        <td>{{ $solusi->detail_p2_1 }}</td>
                        <td>{{ $detailNilai['solusi']['p2']['n16_1'] == 1 ? '1' : '0' }}</td>
                    </tr>
                    <tr class="sub-parameter">
                        <td>{{ $solusi->detail_p2_2 }}</td>
                        <td>{{ $detailNilai['solusi']['p2']['n16_2'] == 1 ? '1' : '0' }}</td>
                    </tr>
                    <tr class="sub-parameter">
                        <td>{{ $solusi->detail_p2_3 }}</td>
                        <td>{{ $detailNilai['solusi']['p2']['n16_3'] == 1 ? '1' : '0' }}</td>
                    </tr>
                    <tr class="sub-parameter">
                        <td>{{ $solusi->detail_p2_4 }}</td>
                        <td>{{ $detailNilai['solusi']['p2']['n16_4'] == 1 ? '1' : '0' }}</td>
                    </tr>
                @endforeach
                <tr class="total-row">
                    <td><strong>TOTAL NILAI PARAMETER SOLUSI</strong></td>
                    <td><strong>{{ $detailNilai['solusi']['total'] }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Dokumen ini dibuat secara otomatis pada {{ date('d F Y H:i:s') }}</p>
        <div style="font-size:9px; color:#888; margin-top:8px;">
            &copy; 2025 vickybahaya &mdash; Sistem Penilaian Quality Monitoring
        </div>
    </div>

    <script>
        // Auto print when page loads
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
