<?php
session_start();
include('../../conf/config.php');
include("../phpfpdf/fpdf.php");

if (!isset($_GET['id-penilaian']) || !isset($_GET['id-pemagang'])) {
    $referer = $_SERVER['HTTP_REFERER'];
    header("Location: $referer");
    exit;
}
$idPenilaian = $_GET['id-penilaian'];
$idPemagang = $_GET['id-pemagang'];
$query = mysqli_query($koneksi, "SELECT * FROM tb_penilaian WHERE id='$idPenilaian'");
$nilai = mysqli_fetch_array($query);
$idPembimbing = $nilai['id_pembimbing'];
$kedisiplinan = $nilai['kedisiplinan'];
$kerapian = $nilai['kerapian'];
$tanggungjwb = $nilai['tanggungjwb'];
$ketaatan = $nilai['ketaatan'];
$etoskerja = $nilai['etoskerja'];
$kerjasama = $nilai['kerjasama'];
$keterampilan = $nilai['keterampilan'];
$feedback = $nilai['feedback'];

$query1 = mysqli_query($koneksi, "SELECT * FROM tb_pemagang WHERE id='$idPemagang'");
$pemagang = mysqli_fetch_array($query1);
$nama = $pemagang['nama'];
$instansi = $pemagang['instansi'];
$fakultas = $pemagang['fakultas'];
$jurusan = $pemagang['jurusan'];
$nim = $pemagang['nim'];

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
$fileName = "Penilaian-" . $nama . "." . $fileType;

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

$pdf->gambar('../../images/dinas.png');

$pdf->judul("PEMERINTAH KABUPATEN PEKALONGAN", "DINAS KOMUNIKASI DAN INFORMATIKA", "Alamat : Jl. Krakatau No. 2 Kajen Kode Pos : 51161", "Telp. (0285) 381781, (Fax) 381781", "Website : dinkominfo.pekalongankab.go.id  |  E-mail : dinkominfo@pekalongankab.go.id");

$pdf->garis();

$pdf->Cell(10, 10, '', 0, 1);

$pdf->SetFont('Times', 'B', '15');
$pdf->Cell(0, 5, 'PENILAIAN PRAKTEK KERJA LAPANGAN', 0, 1, 'C');

$pdf->Cell(10, 7, '', 0, 1);

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
    $pdf->Cell(50, 7, $label, 0, 0, 'L');
    $pdf->Cell(10, 7, ':', 0, 0, 'C');
    $pdf->Cell(0, 7, $value, 0, 1, 'L');
}

$pdf->Cell(10, 2, '', 0, 1);

$pdf->SetX(15);
$pdf->SetFont('Times', 'B', 12);
$pdf->SetLineWidth(0.2);
$pdf->SetFillColor(211, 211, 211);
$pdf->Cell(13, 14, 'No', 1, 0, 'C', true);
$pdf->Cell(115, 14, 'Indikator', 1, 0, 'C', true);
$pdf->Cell(50, 7, 'Nilai', 1, 1, 'C', true);
$pdf->SetX(143);
$pdf->Cell(25, 7, 'Angka', 1, 0, 'C', true);
$pdf->Cell(25, 7, 'Huruf', 1, 1, 'C', true);

$indicators = array(
    '  Kedisiplinan' => array($kedisiplinan, 'A'),
    '  Kerapian' => array($kerapian, 'B'),
    '  Tanggung Jawab' => array($tanggungjwb, 'C'),
    '  Ketaatan' => array($ketaatan, 'D'),
    '  Etos Kerja' => array($etoskerja, 'E'),
    '  Kerja Sama' => array($kerjasama, 'F'),
    '  Keterampilan' => array($keterampilan, 'G')
);

$pdf->SetFont('Times', '', 12);
$no = 1;
$totalAngka = 0; // Variable to store the sum of Angka
foreach ($indicators as $indikator => $data) {
    list($nilai, $huruf) = $data;
    $pdf->SetX(15);
    $pdf->SetLineWidth(0.2);
    $pdf->Cell(13, 7, $no, 1, 0, 'C');
    $pdf->Cell(115, 7, $indikator, 1);
    $pdf->Cell(25, 7, $nilai, 1, 0, 'C');
    if ($nilai > 85) {
        $huruf = 'A';
    } elseif ($nilai >= 70 && $nilai <= 84.9) {
        $huruf = 'B';
    } elseif ($nilai >= 55 && $nilai <= 69.9) {
        $huruf = 'C';
    } elseif ($nilai >= 40 && $nilai <= 54.9) {
        $huruf = 'D';
    } else {
        $huruf = 'E';
    }
    $pdf->Cell(25, 7, $huruf, 1, 1, 'C');
    $no++;
}

$pdf->SetX(15);
$pdf->Cell(128, 7, 'Jumlah  ', 1, 0, 'R');
$sumAngka = 0;
foreach ($indicators as $data) {
    list($nilai, $huruf) = $data;
    $sumAngka += $nilai;
}
$pdf->Cell(25, 7, $sumAngka, 1, 0, 'C');
$totalAngka = array_sum(array_column($indicators, 0));
$averageAngka = $totalAngka / count($indicators);
$formattedAverageAngka = number_format($averageAngka, 2);
$pdf->Cell(25, 7, '', 1, 1, 'C', true);
$pdf->SetX(15);
$pdf->Cell(128, 7, 'Nilai Rata-rata  ', 1, 0, 'R');
$pdf->Cell(25, 7, $formattedAverageAngka, 1, 0, 'C');
$hurufCount = array_count_values(array_column($indicators, 1));
arsort($hurufCount);
$mostFrequentHuruf = key($hurufCount);
$pdf->Cell(25, 7, $mostFrequentHuruf, 1, 1, 'C');


$pdf->Cell(10, 5, '', 0, 1);

$pdf->SetFont('Times', '', 12);
$pdf->SetX(15);
$pdf->Cell(25, 5, 'Keterangan :', 0, 0, 'L');
$pdf->Cell(25, 5, '> 85', 0, 0, 'C');
$pdf->Cell(10, 5, ':   A', 0, 1, 'L');
$pdf->SetX(40);
$pdf->Cell(25, 5, '70 - 84.9', 0, 0, 'C');
$pdf->Cell(10, 5, ':   B', 0, 1, 'L');
$pdf->SetX(40);
$pdf->Cell(25, 5, '55 - 69.9', 0, 0, 'C');
$pdf->Cell(10, 5, ':   C', 0, 1, 'L');
$pdf->SetX(40);
$pdf->Cell(25, 5, '40 - 54.9', 0, 0, 'C');
$pdf->Cell(10, 5, ':   D', 0, 1, 'L');
$pdf->SetX(40);
$pdf->Cell(25, 5, '< 40', 0, 0, 'C');
$pdf->Cell(10, 5, ':   E', 0, 1, 'L');

$pdf->Cell(10, 8, '', 0, 1);

$pkl = "Pekalongan, " . strftime("%d %B %Y", time());

$pdf->SetFont('Times', '', 12);
$pdf->SetX(105);
$pdf->Cell(95, 5, $pkl, 0, 1, 'C');
$pdf->SetX(105);
$pdf->MultiCell(95, 5, 'DINAS KOMUNIKASI DAN INFORMATIKA', 0, 'C');
$pdf->SetX(105);
$pdf->MultiCell(95, 5, 'KABUPATEN PEKALONGAN', 0, 'C');
$pdf->SetX(105);
$pdf->MultiCell(95, 5, $jabatan, 0, 'C');
$pdf->Cell(10, 24, '', 0, 1);
$pdf->SetX(105);
$pdf->Cell(95, 5, $namaPembimbing, 0, 1, 'C');
$pdf->SetX(105);
$pdf->Cell(95, 5, $nip, 0, 1, 'C');

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . $fileName . '"');

$pdf->Output($fileName, 'D');
