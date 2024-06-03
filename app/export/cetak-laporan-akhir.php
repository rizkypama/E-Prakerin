<?php
session_start();
include('../../conf/config.php');
include("../phpfpdf/fpdf.php");

if (!isset($_GET['id-pemagang'])) {
    $referer = $_SERVER['HTTP_REFERER'];
    header("Location: $referer");
    exit;
}
$idPemagang = $_GET['id-pemagang'];
$query = mysqli_query($koneksi, "SELECT * FROM tb_laporan_harian WHERE id_pemagang='$idPemagang' AND status='disetujui' ORDER BY created_at DESC");

$query1 = mysqli_query($koneksi, "SELECT * FROM tb_pemagang WHERE id='$idPemagang'");
$pemagang = mysqli_fetch_array($query1);
$nama = $pemagang['nama'];
$instansi = $pemagang['instansi'];
$fakultas = $pemagang['fakultas'];
$jurusan = $pemagang['jurusan'];
$nim = $pemagang['nim'];
$idPembimbing = $pemagang['id_pembimbing'];

$tglmulai = $pemagang['tglmulai'];
$tglselesai = $pemagang['tglselesai'];
$months = array(
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
);
$tglmulaiParts = explode('-', $tglmulai);
$tglselesaiParts = explode('-', $tglselesai);

$tanggalPelaksanaan = $tglmulaiParts[2] . ' ' . $months[(int)$tglmulaiParts[1]] . ' ' . $tglmulaiParts[0] . ' - ' .
    $tglselesaiParts[2] . ' ' . $months[(int)$tglselesaiParts[1]] . ' ' . $tglselesaiParts[0];


$query2 = mysqli_query($koneksi, "SELECT nama_pembimbing, jabatan, nip FROM tb_pembimbing WHERE id='$idPembimbing'");
$pembimbing = mysqli_fetch_array($query2);
$namaPembimbing = $pembimbing['nama_pembimbing'];
$jabatan = $pembimbing['jabatan'];
$nip = "NIP. " . $pembimbing['nip'];

$fileType = 'pdf';
$fileName = "Laporan-" . $nama . "." . $fileType;

class Pdf extends FPDF
{
    function gambar($gambar)

    {
        $this->Image($gambar, 10, 10, 20, 25);
    }
    function judul($teks1, $teks2, $teks3, $teks4, $teks5)
    {
        $this->Cell(25);
        $this->SetFont('Times', '', '14');
        $this->Cell(0, 5, $teks1, 0, 1, 'C');
        $this->Cell(25);
        $this->SetFont('Times', 'B', '16');
        $this->Cell(0, 8, $teks2, 0, 1, 'C');
        $this->Cell(25);
        $this->SetFont('Times', 'B', '12');
        $this->Cell(0, 5, $teks3, 0, 1, 'C');
        $this->Cell(25);
        $this->SetFont('Times', 'B', '12');
        $this->Cell(0, 5, $teks4, 0, 1, 'C');
        $this->Cell(25);
        $this->SetFont('Times', 'I', '12');
        $this->Cell(0, 5, $teks5, 0, 1, 'C');
    }

    function garis()
    {
        $this->SetLineWidth(0);
        $this->Line(10, 41, 200, 41);
        $this->SetLineWidth(1);
        $this->Line(10, 40, 200, 40);
    }
}

$pdf = new Pdf();

$pdf->AddPage('P', 'A4');

$topMarginFirstPage = 10;

$pdf->SetMargins(10, $topMarginFirstPage);

$pdf->gambar('../../images/dinas.png');

$pdf->judul("PEMERINTAH KABUPATEN PEKALONGAN", "DINAS KOMUNIKASI DAN INFORMATIKA", "Alamat : Jl. Krakatau No. 2 Kajen Kode Pos : 51161", "Telp. (0285) 381781, (Fax) 381781", "Website : dinkominfo.pekalongankab.go.id  |  E-mail : dinkominfo@pekalongankab.go.id");

$pdf->garis();

$pdf->Cell(10, 10, '', 0, 1);

$pdf->SetFont('Times', 'B', '15');
$pdf->Cell(0, 5, 'LEMBAR ASISTENSI PRAKTIK KERJA LAPANGAN', 0, 1, 'C');

$pdf->Cell(10, 7, '', 0, 1);

// Write the body here
$pdf->SetFont('Times', '', 12);
$data = array(
    'Nama Peserta Magang' => $nama,
    'Perguruan Tinggi / Sekolah' => $instansi,
    'Fakultas' => $fakultas,
    'Jurusan' => $jurusan,
    'NIM / NIS' => $nim,
    'Tanggal Pelaksanaan' => $tanggalPelaksanaan
);

foreach ($data as $label => $value) {
    $pdf->SetX(15);
    $pdf->Cell(50, 8, $label, 0, 0, 'L');
    $pdf->Cell(10, 8, ':', 0, 0, 'C');
    $pdf->Cell(0, 8, $value, 0, 1, 'L');
}

$pdf->Cell(10, 7, '', 0, 1);

$pdf->SetX(15);
$pdf->SetFont('Times', 'B', 12);
$pdf->SetLineWidth(0.2);
$pdf->SetFillColor(211, 211, 211);
$pdf->Cell(13, 10, 'No', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Tanggal', 1, 0, 'C', true);
$pdf->Cell(110, 10, 'Uraian', 1, 0, 'C', true);
$pdf->Cell(15, 10, 'Paraf', 1, 1, 'C', true);

$no = 1;
while ($hasil = mysqli_fetch_array($query)) {
    $pdf->SetFont('Times', '', 12);

    $pdf->SetX(15);
    $cellWidth = 110;
    $cellHeight = 5;

    if ($pdf->GetStringWidth($hasil['deskripsi_kegiatan']) < $cellWidth) {
        $line = 1;
    } else {
        $textLength = strlen($hasil['deskripsi_kegiatan']);
        $errMargin = 5;
        $startChar = 0;
        $maxChar = 0;
        $textArray = array();
        $tmpString = "";

        while ($startChar < $textLength) {
            while (
                $pdf->GetStringWidth($tmpString) < ($cellWidth - $errMargin) &&
                ($startChar + $maxChar) < $textLength
            ) {
                $maxChar++;
                $tmpString = substr($hasil['deskripsi_kegiatan'], $startChar, $maxChar);
            }
            $startChar = $startChar + $maxChar;
            array_push($textArray, $tmpString);
            $maxChar = 0;
            $tmpString = '';
        }
        $line = count($textArray);
    }

    $pdf->SetFillColor(255, 255, 255);
    $pdf->Cell(13, ($line * $cellHeight), $no++, 1, 0, 'C', true);

    $monthNames = array(
        'January' => 'Januari',
        'February' => 'Februari',
        'March' => 'Maret',
        'April' => 'April',
        'May' => 'Mei',
        'June' => 'Juni',
        'July' => 'Juli',
        'August' => 'Agustus',
        'September' => 'September',
        'October' => 'Oktober',
        'November' => 'November',
        'December' => 'Desember'
    );

    $createdDate = strtotime($hasil['created_at']);
    $englishMonth = date('F', $createdDate);
    $indonesianMonth = $monthNames[$englishMonth];
    $formattedDate = date('d', $createdDate) . ' ' . $indonesianMonth . ' ' . date('Y', $createdDate);

    $pdf->Cell(40, ($line * $cellHeight), $formattedDate, 1, 0);
    $xPos = $pdf->GetX();
    $yPos = $pdf->GetY();
    $pdf->MultiCell($cellWidth, $cellHeight, $hasil['deskripsi_kegiatan'], 1);
    $pdf->SetXY($xPos + $cellWidth, $yPos);

    $pdf->Cell(15, ($line * $cellHeight), '', 1, 1);
}

$pdf->Cell(10, 14, '', 0, 1);

$pkl = "Pekalongan, " . strftime("%d %B %Y", time());

$boxX = 100;
$boxY = $pdf->GetY();
$pageHeight = $pdf->GetPageHeight();

$pageBreakThreshold = $pageHeight - 60;

if ($boxY > $pageBreakThreshold) {
    $pdf->SetMargins(10, 20);
    $pdf->AddPage();
    $boxY = $pdf->GetY();
    $contentY = $pageHeight - 50;
}
$pdf->SetFillColor(255, 255, 255);
$pdf->Rect($boxX, $boxY, 95, 60, 'F'); // Draw a rectangle around the content
$pdf->SetXY($boxX, $boxY); // Set the cursor position to start inside the rectangle

$pdf->SetFont('Times', '', 12);

// Combine the text into a single string with line breaks
$content = "$pkl\nDINAS KOMUNIKASI DAN INFORMATIKA\nKABUPATEN PEKALONGAN\n$jabatan\n\n\n\n\n\n$namaPembimbing\n$nip";

// Output the combined content inside the rectangle
$pdf->MultiCell(95, 5, $content, 0, 'C');

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . $fileName . '"');

$pdf->Output($fileName, 'D');
