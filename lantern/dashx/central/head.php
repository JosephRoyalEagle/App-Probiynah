<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Vendor CSS Files -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.2/css/buttons.dataTables.css">
<link rel="stylesheet" href="https://cdn.datatables.net/scroller/2.4.3/css/scroller.dataTables.css">
<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/main.css">
<link href="assets/img/LOGOPB.png" type="image/png" rel="icon">
<link href="assets/img/LOGOPB.png" type="image/png" rel="shortcut icon">
<link href="assets/img/LOGOPB.png" type="image/png" rel="apple-touch-icon">
<style>
    .dataTables_filter input {
        border: 2px solid black;
        margin-bottom: 5px;
        border-radius: 0%;
    }

    .dataTables_filter input:focus {
        border: 2px solid black;
        box-shadow: none;
        outline: none;
        border-radius: 0%;
    }

    body.dt-print-view h1 {
        text-align: center;
        margin: 1em;
    }

    .btn-imprimer-custom {
        background-color: #eb3b5a;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 5px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-imprimer-custom:hover {
        background-color: #eb3b5a;
    }

    /* STYLE PAGE RESTAURANT INEXISTANT*/
    .no-results-section {
        display: none;
        /* Masquer la section par défaut */
    }

    .no-results-section {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 340px;
        padding: 40px 0 45px 0;
        background: linear-gradient(120deg, #f6f7fb 40%, #e6ecfe 100%);
    }

    .no-results-container {
        background: #fff;
        border-radius: 14px;
        max-width: 410px;
        width: 100%;
        padding: 38px 26px 34px 26px;
        box-shadow: 0 4px 24px 0 rgba(67, 97, 238, 0.09), 0 1.5px 4px 0 rgba(90, 108, 172, 0.08);
        text-align: center;
        animation: fadeIn 0.8s;
    }

    .no-results-icon {
        font-size: 2.7rem;
        color: #f94144;
        margin-bottom: 18px;
        animation: bounceNFade 1.1s infinite alternate;
    }

    @keyframes bounceNFade {
        0% {
            transform: translateY(0) scale(1);
            opacity: 1;
        }

        60% {
            transform: translateY(-10px) scale(1.08);
        }

        100% {
            transform: translateY(0) scale(1.02);
            opacity: 0.93;
        }
    }

    .no-results-container h2 {
        font-size: 1.34rem;
        color: #222b45;
        margin-bottom: 12px;
        font-weight: 700;
    }

    .no-results-container p {
        color: #636e90;
        font-size: 1.04rem;
        margin: 0;
        line-height: 1.55;
    }

    @media (max-width: 600px) {
        .no-results-container {
            max-width: 97vw;
            padding: 21px 4vw 18px 4vw;
        }

        .no-results-section {
            min-height: 180px;
            padding: 18px 0 18px 0;
        }

        .no-results-icon {
            font-size: 1.7rem;
            margin-bottom: 9px;
        }
    }
</style>
<noscript>
    <style>
        body {
            display: none;
        }
    </style>
    <meta http-equiv="refresh" content="0; URL=../../../javascript-disabled.html">
</noscript>