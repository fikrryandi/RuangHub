<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>Login - RuangHub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Inter',sans-serif;min-height:100vh;overflow:hidden;background:#1976D2}
        .login-bg{position:fixed;inset:0;background:linear-gradient(130deg,#1040a0 0%,#1565C0 25%,#1976D2 55%,#29b6f6 100%);z-index:0;overflow:hidden}
        .bg-wave-1{position:absolute;top:-120px;right:-100px;width:580px;height:480px;background:rgba(255,255,255,0.09);border-radius:50% 30% 60% 40%;transform:rotate(-20deg)}
        .bg-wave-2{position:absolute;top:-60px;right:100px;width:380px;height:320px;background:rgba(255,255,255,0.06);border-radius:40% 60% 30% 70%;transform:rotate(-8deg)}
        .bg-wave-3{position:absolute;bottom:-150px;left:-80px;width:480px;height:380px;background:rgba(255,255,255,0.05);border-radius:60% 40% 50% 50%;transform:rotate(15deg)}
        .bg-dots{position:absolute;inset:0;background-image:radial-gradient(circle,rgba(255,255,255,0.18) 1.5px,transparent 1.5px);background-size:32px 32px;opacity:.5}
        .dot-grp{position:absolute;display:grid;grid-template-columns:repeat(4,1fr);gap:6px}
        .dot-grp span{width:5px;height:5px;background:rgba(255,255,255,0.28);border-radius:50%;display:block}
        .dot-grp.tl{top:36px;left:36px}
        .dot-grp.br{bottom:36px;right:380px}

        .page-wrap{position:relative;z-index:1;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px}
        .main-cont{width:100%;max-width:1160px;display:flex;align-items:center;gap:36px}

        /* ── ANIMATIONS ── */
        @keyframes fadeInUp{0%{opacity:0;transform:translateY(30px)}100%{opacity:1;transform:translateY(0)}}
        @keyframes fadeInLeft{0%{opacity:0;transform:translateX(-40px)}100%{opacity:1;transform:translateX(0)}}
        @keyframes fadeInRight{0%{opacity:0;transform:translateX(40px)}100%{opacity:1;transform:translateX(0)}}

        /* ── LEFT ── */
        .left-panel{flex:1;display:flex;flex-direction:column;color:white;padding-right:16px;animation:fadeInLeft 1s cubic-bezier(0.16, 1, 0.3, 1) forwards}
        .brand-row{display:flex;align-items:center;gap:14px;margin-bottom:24px}
        .brand-row img{width:52px;height:52px;object-fit:contain;filter:drop-shadow(0 4px 8px rgba(0,0,0,.2))}
        .brand-row .bt h1{font-size:30px;font-weight:800;color:#fff;line-height:1;letter-spacing:-.5px}
        .brand-row .bt p{font-size:12px;color:rgba(255,255,255,.75);margin-top:3px;font-weight:500}
        .hero-h{font-size:36px;font-weight:800;line-height:1.22;color:#fff;margin-bottom:12px;letter-spacing:-.5px}
        .hero-h span{color:#a8d8ff}
        .hero-p{font-size:14.5px;color:rgba(255,255,255,.82);line-height:1.7;max-width:400px;margin-bottom:24px}

        /* illustration */
        .illus-wrap{position:relative;width:100%;max-width:460px}
        .float-badge{position:absolute;background:#fff;border-radius:14px;box-shadow:0 8px 28px rgba(0,0,0,.18);display:flex;align-items:center;gap:9px;padding:9px 15px;font-size:12.5px;font-weight:600;color:#1a1a2e;animation:flt 3s ease-in-out infinite;white-space:nowrap}
        .float-badge.tp{top:8px;right:-8px;animation-delay:.5s}
        .float-badge.lf{bottom:85px;left:-18px;animation-delay:1s}
        @keyframes flt{0%,100%{transform:translateY(0)}50%{transform:translateY(-8px)}}
        .fbbl{position:absolute;border-radius:14px;display:flex;align-items:center;justify-content:center;box-shadow:0 8px 22px rgba(0,0,0,.15);animation:flt 2.5s ease-in-out infinite}
        .bbl-loc{top:-14px;right:108px;width:48px;height:48px;background:#0d47a1;animation-delay:.2s}
        .bbl-team{top:58px;right:-18px;width:54px;height:54px;background:#0d47a1;animation-delay:.8s}
        .bbl-clk{bottom:38px;right:2px;width:62px;height:62px;background:#fff;animation-delay:.3s}

        /* features */
        .feat-row{display:flex;gap:24px;margin-top:24px}
        .feat-item{display:flex;flex-direction:column;align-items:center;gap:7px}
        .feat-icon{width:52px;height:52px;border-radius:14px;background:rgba(255,255,255,.13);border:1px solid rgba(255,255,255,.22);backdrop-filter:blur(8px);display:flex;align-items:center;justify-content:center;color:#fff;box-shadow:0 4px 14px rgba(0,0,0,.1);transition:transform .2s,background .2s}
        .feat-icon:hover{transform:translateY(-4px);background:rgba(255,255,255,.2)}
        .feat-item span{font-size:11.5px;font-weight:600;color:rgba(255,255,255,.9);text-align:center;line-height:1.3}

        /* ── FORM CARD ── */
        .form-card{background:#fff;border-radius:28px;box-shadow:0 30px 80px rgba(0,0,0,.24),0 8px 24px rgba(0,0,0,.1);padding:38px 36px 28px;width:100%;max-width:396px;flex-shrink:0;animation:fadeInRight 1s cubic-bezier(0.16, 1, 0.3, 1) forwards;opacity:0;animation-delay:0.2s}
        .card-brand{display:flex;align-items:center;gap:10px;margin-bottom:22px}
        .card-brand img{width:34px;height:34px;object-fit:contain}
        .cb-name{font-size:19px;font-weight:800;color:#1565C0;line-height:1}
        .cb-sub{font-size:10.5px;color:#9ca3af;font-weight:500;margin-top:2px}
        .card-title{font-size:23px;font-weight:800;color:#111827;margin-bottom:3px}
        .card-sub{font-size:13px;color:#6b7280;margin-bottom:26px}

        .inp-grp{position:relative;display:flex;align-items:center;background:#f0f7ff;border:1.5px solid #e0efff;border-radius:12px;overflow:hidden;transition:border-color .2s,box-shadow .2s,background .2s;margin-bottom:13px}
        .inp-grp:focus-within{border-color:#1565C0;background:#fff;box-shadow:0 0 0 4px rgba(21,101,192,.1)}
        .inp-pre{padding:0 11px 0 15px;color:#9ca3af;display:flex;align-items:center;flex-shrink:0}
        .inp-grp input{flex:1;border:none;background:transparent;padding:13px 8px 13px 0;font-size:13.5px;color:#1f2937;outline:none;font-family:'Inter',sans-serif}
        .inp-grp input::placeholder{color:#9ca3af}
        .inp-suf{padding:0 13px;color:#9ca3af;display:flex;align-items:center;cursor:pointer;transition:color .2s;background:none;border:none}
        .inp-suf:hover{color:#6b7280}
        .clr-btn{background:#e5e7eb;border-radius:50%;padding:3px;display:flex}

        .rem-row{display:flex;align-items:center;justify-content:space-between;margin-bottom:16px}
        .rem-label{display:flex;align-items:center;gap:7px;cursor:pointer}
        .rem-label input[type=checkbox]{width:15px;height:15px;accent-color:#1565C0;cursor:pointer}
        .rem-label span{font-size:13px;color:#374151;font-weight:500}
        .fgt-link{font-size:13px;font-weight:600;color:#1565C0;text-decoration:none;transition:color .2s}
        .fgt-link:hover{color:#0d47a1}

        .btn-login{width:100%;display:flex;align-items:center;justify-content:center;gap:9px;padding:14px 20px;background:linear-gradient(135deg,#1565C0 0%,#1e90ff 100%);color:#fff;font-size:15px;font-weight:700;border:none;border-radius:12px;cursor:pointer;transition:all .3s ease;box-shadow:0 6px 20px rgba(21,101,192,.35);font-family:'Inter',sans-serif;letter-spacing:.3px}
        .btn-login:hover{transform:translateY(-2px);box-shadow:0 10px 28px rgba(21,101,192,.45);background:linear-gradient(135deg,#0d47a1 0%,#1565C0 100%)}
        .btn-login:active{transform:translateY(0)}

        .divider{position:relative;text-align:center;margin:20px 0}
        .divider::before{content:'';position:absolute;top:50%;left:0;right:0;height:1px;background:#e5e7eb}
        .divider span{position:relative;background:#fff;padding:0 14px;font-size:11px;font-weight:700;color:#9ca3af;letter-spacing:1.5px;text-transform:uppercase}

        .btn-google{width:100%;display:flex;align-items:center;justify-content:center;gap:10px;padding:12px 20px;background:#fff;border:1.5px solid #e5e7eb;border-radius:12px;font-size:14px;font-weight:600;color:#374151;text-decoration:none;transition:all .25s ease;box-shadow:0 2px 8px rgba(0,0,0,.05);font-family:'Inter',sans-serif}
        .btn-google:hover{background:#f9fafb;border-color:#d1d5db;box-shadow:0 4px 14px rgba(0,0,0,.1);transform:translateY(-1px)}

        .card-footer{margin-top:20px;text-align:center;font-size:11.5px;color:#9ca3af}
        .err-msg{font-size:12px;color:#dc2626;margin-top:-7px;margin-bottom:9px;padding-left:3px}
        .sess-ok{font-size:13px;color:#16a34a;background:#f0fdf4;border:1px solid #86efac;border-radius:8px;padding:9px 13px;margin-bottom:14px}

        @media(max-width:900px){.left-panel{display:none}.form-card{max-width:100%}.main-cont{justify-content:center}body{overflow:auto}}
    </style>
</head>
<body>
<div class="login-bg">
    <div class="bg-wave-1"></div>
    <div class="bg-wave-2"></div>
    <div class="bg-wave-3"></div>
    <div class="bg-dots"></div>
    <div class="dot-grp tl">@for($i=0;$i<12;$i++)<span></span>@endfor</div>
    <div class="dot-grp br">@for($i=0;$i<12;$i++)<span></span>@endfor</div>
</div>

<div class="page-wrap">
<div class="main-cont">

<!-- LEFT PANEL -->
<div class="left-panel">
    <div class="brand-row">
        <img src="{{ asset('favicon.png') }}" alt="RuangHub">
        <div class="bt"><h1>RuangHub</h1><p>Room Booking System</p></div>
    </div>

    <h2 class="hero-h">Booking ruang lebih mudah,<br>kerja <span>lebih produktif</span></h2>
    <p class="hero-p">Kelola pemesanan ruang meeting, ruangan kerja, dan fasilitas lainnya dalam satu sistem yang praktis dan terintegrasi.</p>

    <!-- ILLUSTRATION -->
    <div class="illus-wrap">
        <!-- Floating badges -->
        <div class="float-badge tp">
            <svg width="15" height="15" fill="none" stroke="#22c55e" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Booking Dikonfirmasi
        </div>
        <div class="float-badge lf">
            <svg width="15" height="15" fill="none" stroke="#f59e0b" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            14:00 - 16:00
        </div>
        <!-- Floating bubbles -->
        <div class="fbbl bbl-loc">
            <svg width="22" height="22" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
        </div>
        <div class="fbbl bbl-team">
            <svg width="24" height="24" fill="none" stroke="white" stroke-width="1.8" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
        </div>
        <div class="fbbl bbl-clk">
            <svg width="28" height="28" fill="none" stroke="#1565C0" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>

        <!-- LAPTOP SVG ILLUSTRATION -->
        <svg viewBox="0 0 460 290" xmlns="http://www.w3.org/2000/svg" style="width:100%;filter:drop-shadow(0 18px 36px rgba(0,0,0,.25))">
            <!-- Shadow -->
            <ellipse cx="252" cy="260" rx="158" ry="12" fill="rgba(0,0,0,.12)"/>
            <!-- Laptop base -->
            <rect x="112" y="244" width="280" height="16" rx="6" fill="#cbd5e1"/>
            <rect x="143" y="246" width="138" height="10" rx="3" fill="#94a3b8"/>
            <rect x="236" y="246" width="32" height="5" rx="2.5" fill="#64748b"/>
            <!-- Screen bezel -->
            <rect x="128" y="80" width="248" height="166" rx="12" fill="#e2e8f0"/>
            <!-- Screen inner -->
            <rect x="138" y="90" width="228" height="146" rx="8" fill="#f8fafc"/>
            <!-- Calendar header -->
            <rect x="138" y="90" width="228" height="32" rx="8" fill="#1565C0"/>
            <text x="152" y="111" font-family="Inter,sans-serif" font-size="12" font-weight="700" fill="white">Oktober 2026</text>
            <text x="322" y="111" font-family="Inter,sans-serif" font-size="12" fill="rgba(255,255,255,0.7)">&#8249; &#8250;</text>
            <!-- Day labels -->
            <text x="149" y="134" font-size="8.5" fill="#64748b" font-family="Inter,sans-serif" font-weight="600">MIN</text>
            <text x="179" y="134" font-size="8.5" fill="#64748b" font-family="Inter,sans-serif" font-weight="600">SEN</text>
            <text x="209" y="134" font-size="8.5" fill="#64748b" font-family="Inter,sans-serif" font-weight="600">SEL</text>
            <text x="239" y="134" font-size="8.5" fill="#64748b" font-family="Inter,sans-serif" font-weight="600">RAB</text>
            <text x="269" y="134" font-size="8.5" fill="#64748b" font-family="Inter,sans-serif" font-weight="600">KAM</text>
            <text x="298" y="134" font-size="8.5" fill="#64748b" font-family="Inter,sans-serif" font-weight="600">JUM</text>
            <text x="329" y="134" font-size="8.5" fill="#64748b" font-family="Inter,sans-serif" font-weight="600">SAB</text>
            <!-- Row 1 cells -->
            <rect x="145" y="139" width="24" height="18" rx="4" fill="#f0f7ff"/>
            <rect x="175" y="139" width="24" height="18" rx="4" fill="#f0f7ff"/>
            <rect x="205" y="139" width="24" height="18" rx="4" fill="#f0f7ff"/>
            <rect x="235" y="139" width="24" height="18" rx="4" fill="#dbeafe"/>
            <rect x="265" y="139" width="24" height="18" rx="4" fill="#f0f7ff"/>
            <rect x="295" y="139" width="24" height="18" rx="4" fill="#f0f7ff"/>
            <rect x="325" y="139" width="24" height="18" rx="4" fill="#f0f7ff"/>
            <!-- Row 2 cells -->
            <rect x="145" y="161" width="24" height="18" rx="4" fill="#f0f7ff"/>
            <rect x="175" y="161" width="24" height="18" rx="4" fill="#f0f7ff"/>
            <rect x="205" y="161" width="24" height="18" rx="4" fill="#dbeafe"/>
            <rect x="235" y="161" width="24" height="18" rx="4" fill="#f0f7ff"/>
            <rect x="265" y="161" width="24" height="18" rx="4" fill="#f0f7ff"/>
            <!-- RED highlight date -->
            <rect x="295" y="161" width="24" height="18" rx="4" fill="#ef4444"/>
            <text x="307" y="174" text-anchor="middle" font-size="9" fill="white" font-family="Inter,sans-serif" font-weight="700">2</text>
            <rect x="325" y="161" width="24" height="18" rx="4" fill="#f0f7ff"/>
            <!-- Row 3 cells -->
            <rect x="145" y="183" width="24" height="18" rx="4" fill="#f0f7ff"/>
            <rect x="175" y="183" width="24" height="18" rx="4" fill="#dbeafe"/>
            <rect x="205" y="183" width="24" height="18" rx="4" fill="#f0f7ff"/>
            <rect x="235" y="183" width="24" height="18" rx="4" fill="#f0f7ff"/>
            <rect x="265" y="183" width="24" height="18" rx="4" fill="#dbeafe"/>
            <rect x="295" y="183" width="24" height="18" rx="4" fill="#f0f7ff"/>
            <rect x="325" y="183" width="24" height="18" rx="4" fill="#f0f7ff"/>
            <!-- Row 4 cells -->
            <rect x="145" y="205" width="24" height="16" rx="4" fill="#f0f7ff"/>
            <rect x="175" y="205" width="24" height="16" rx="4" fill="#f0f7ff"/>
            <rect x="205" y="205" width="24" height="16" rx="4" fill="#f0f7ff"/>
            <rect x="235" y="205" width="24" height="16" rx="4" fill="#dbeafe"/>
            <rect x="265" y="205" width="24" height="16" rx="4" fill="#f0f7ff"/>
            <rect x="295" y="205" width="24" height="16" rx="4" fill="#f0f7ff"/>
            <rect x="325" y="205" width="24" height="16" rx="4" fill="#f0f7ff"/>
            <!-- Row 1 numbers -->
            <text x="157" y="152" text-anchor="middle" font-size="8.5" fill="#94a3b8" font-family="Inter,sans-serif">29</text>
            <text x="187" y="152" text-anchor="middle" font-size="8.5" fill="#94a3b8" font-family="Inter,sans-serif">30</text>
            <text x="217" y="152" text-anchor="middle" font-size="8.5" fill="#374151" font-family="Inter,sans-serif">1</text>
            <text x="247" y="152" text-anchor="middle" font-size="8.5" fill="#1565C0" font-family="Inter,sans-serif" font-weight="700">2</text>
            <text x="277" y="152" text-anchor="middle" font-size="8.5" fill="#374151" font-family="Inter,sans-serif">3</text>
            <text x="307" y="152" text-anchor="middle" font-size="8.5" fill="#374151" font-family="Inter,sans-serif">4</text>
            <text x="337" y="152" text-anchor="middle" font-size="8.5" fill="#374151" font-family="Inter,sans-serif">5</text>
            <!-- Row 2 numbers -->
            <text x="157" y="174" text-anchor="middle" font-size="8.5" fill="#374151" font-family="Inter,sans-serif">6</text>
            <text x="187" y="174" text-anchor="middle" font-size="8.5" fill="#374151" font-family="Inter,sans-serif">7</text>
            <text x="217" y="174" text-anchor="middle" font-size="8.5" fill="#1565C0" font-family="Inter,sans-serif" font-weight="600">8</text>
            <text x="247" y="174" text-anchor="middle" font-size="8.5" fill="#374151" font-family="Inter,sans-serif">9</text>
            <text x="277" y="174" text-anchor="middle" font-size="8.5" fill="#374151" font-family="Inter,sans-serif">10</text>
            <text x="337" y="174" text-anchor="middle" font-size="8.5" fill="#374151" font-family="Inter,sans-serif">12</text>
            <!-- Row 3 numbers -->
            <text x="157" y="196" text-anchor="middle" font-size="8.5" fill="#374151" font-family="Inter,sans-serif">13</text>
            <text x="187" y="196" text-anchor="middle" font-size="8.5" fill="#1565C0" font-family="Inter,sans-serif" font-weight="600">14</text>
            <text x="217" y="196" text-anchor="middle" font-size="8.5" fill="#374151" font-family="Inter,sans-serif">15</text>
            <text x="247" y="196" text-anchor="middle" font-size="8.5" fill="#374151" font-family="Inter,sans-serif">16</text>
            <text x="277" y="196" text-anchor="middle" font-size="8.5" fill="#1565C0" font-family="Inter,sans-serif" font-weight="600">17</text>
            <text x="307" y="196" text-anchor="middle" font-size="8.5" fill="#374151" font-family="Inter,sans-serif">18</text>
            <text x="337" y="196" text-anchor="middle" font-size="8.5" fill="#374151" font-family="Inter,sans-serif">19</text>
            <!-- Camera dot -->
            <circle cx="252" cy="85" r="3" fill="#94a3b8"/>

            <!-- Plant -->
            <rect x="50" y="222" width="28" height="26" rx="4" fill="#b45309"/>
            <rect x="46" y="216" width="36" height="10" rx="3" fill="#92400e"/>
            <path d="M64 214 Q38 186 46 164 Q58 181 64 196" fill="#15803d"/>
            <path d="M64 210 Q92 184 80 161 Q68 179 64 194" fill="#16a34a"/>
            <path d="M64 212 Q47 196 51 176 Q59 188 64 204" fill="#22c55e"/>
            <line x1="64" y1="216" x2="64" y2="196" stroke="#15803d" stroke-width="2.5"/>
            <ellipse cx="64" cy="250" rx="26" ry="5" fill="rgba(0,0,0,0.1)"/>
        </svg>
    </div>

    <!-- FEATURES -->
    <div class="feat-row">
        <div class="feat-item">
            <div class="feat-icon">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <span>Booking<br>Ruang</span>
        </div>
        <div class="feat-item">
            <div class="feat-icon">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
            </div>
            <span>Manajemen<br>Pengguna</span>
        </div>
        <div class="feat-item">
            <div class="feat-icon">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
            </div>
            <span>Notifikasi<br>Real-time</span>
        </div>
        <div class="feat-item">
            <div class="feat-icon">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <span>Akses Aman<br>&amp; Terpercaya</span>
        </div>
    </div>
</div>

<!-- FORM CARD -->
<div class="form-card">
    <div class="card-brand">
        <img src="{{ asset('favicon.png') }}" alt="RuangHub">
        <div>
            <div class="cb-name">RuangHub</div>
            <div class="cb-sub">Room Booking System</div>
        </div>
    </div>

    <h2 class="card-title">Selamat Datang!</h2>
    <p class="card-sub">Silakan login untuk melanjutkan ke sistem</p>

    @if (session('status'))
        <div class="sess-ok">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}" x-data="{ showPwd: false, em: '{{ old('email') }}', pw: '' }">
        @csrf
        <!-- Email -->
        <div class="inp-grp">
            <div class="inp-pre">
                <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <input id="email" type="email" name="email" x-model="em" required autofocus autocomplete="username" placeholder="fikriyandi@ruanghub.com">
            <button type="button" x-show="em.length > 0" @click="em = ''" class="inp-suf">
                <div class="clr-btn"><svg width="10" height="10" viewBox="0 0 20 20" fill="#6b7280"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg></div>
            </button>
        </div>
        @error('email')<div class="err-msg">{{ $message }}</div>@enderror

        <!-- Password -->
        <div class="inp-grp">
            <div class="inp-pre">
                <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
            </div>
            <input id="password" :type="showPwd ? 'text' : 'password'" name="password" x-model="pw" required autocomplete="current-password" placeholder="••••••••••">
            <button type="button" @click="showPwd = !showPwd" class="inp-suf">
                <svg x-show="!showPwd" width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                <svg x-show="showPwd" style="display:none" width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
            </button>
        </div>
        @error('password')<div class="err-msg">{{ $message }}</div>@enderror

        <!-- Remember + Forgot -->
        <div class="rem-row">
            <label class="rem-label">
                <input type="checkbox" name="remember" checked>
                <span>Ingat saya</span>
            </label>
            @if (Route::has('password.request'))
                <a class="fgt-link" href="{{ route('password.request') }}">Lupa password?</a>
            @endif
        </div>

        <!-- Submit -->
        <button type="submit" class="btn-login">
            Login
            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </button>
    </form>

    <div class="divider"><span>ATAU</span></div>

    <a href="{{ route('auth.google.redirect') }}" class="btn-google">
        <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
        </svg>
        Login dengan Google
    </a>

    <div class="card-footer">RuangHub &copy; {{ date('Y') }}. Semua hak dilindungi.</div>
</div>

</div>
</div>
</body>
</html>
