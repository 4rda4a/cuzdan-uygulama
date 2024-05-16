<?php
require('fpdf/fpdf.php');
class PDF extends FPDF
{
	function Header()
	{
		$ay = $_GET["ay"];
		$yil = $_GET["yil"];
		$date = date('d/m/Y');
		$this->Setfont('courier', 'B', 20);
		$this->Image('img/a_logo.png', 5, 5, 30);
		$this->Cell(140);
		$this->Cell(30, 10, 'AYLIK GIDER TABLOSU', 0, 1, 'C');
		$this->Setfont('courier', '', 15);
		$this->Cell(150);
		$this->Cell(30, 10, 'AY : ' . $ay . ' - ' . $yil, 0, 1, 'C');
		$this->Cell(142);
		$this->Cell(30, 10, 'TARIH : ' . $date, 0, 1, 'C');
		$this->Cell(20);
		$this->Ln(10);
	}
	//[ Başlık  Bitiş]
	//[ Tablo Üst Bilgi]
	function HeaderTable()
	{
		$this->Setfont('courier', 'B', 16);
		$this->Cell(30, 6, 'TARIH', 1, 0, 'C');
		$this->Cell(130, 6, 'ACIKLAMA', 1, 0, 'C');
		$this->Cell(30, 6, 'FIYAT', 1, 1, 'C');
	}

	//[ Tablo Üst Bilgi Bitiş]

	//[ Tablo  Bilgi ]
	function MainTable()
	{
		$this->Setfont('courier', 'i', 13);
		$top = 0;
		require "baglan.php";
		$ay = clean($_GET["t"]);
		$yil = substr($ay, 3);
		$ay_id = substr($ay, 0, 2);
		$ay_id_eksi = substr($ay, 0, 2) - 1;
		$m = $ay_id . "." . $yil;
		$veri_sql = $conn->prepare("SELECT * FROM tarihler WHERE tarih LIKE '%$m%' ORDER BY tarih ASC");
		$veri_sql->execute();
		$veri_b = $veri_sql->fetchAll();
		foreach ($veri_b as $key => $veri_b) {
			$icerik = $conn->prepare("SELECT * FROM giderler WHERE tarih ='$veri_b[id]'");
			$icerik->execute();
			$toplam_icerik = $icerik->rowCount();
			$icerikgetir = $icerik->fetchAll(PDO::FETCH_ASSOC);
			$toplam = 0;
			foreach ($icerikgetir as $key => $veri) {
				$this->Cell(30, 6, $veri_b["tarih"], 1, 0, 0, false, 'C');
				$this->Cell(130, 6, te($veri["aciklama"]), 1, 0, 'C');
				$this->Cell(30, 6, $veri["gider"] . ' TL', 1, 1, 'C');
				$toplam = $toplam + $veri["gider"];
			}
			$this->Cell(190, 6, $veri_b["tarih"] . " = " . $toplam . ' TL', 1, 1, 'C');
			$this->Cell(190, 6, '', 0, 1, 'C');
			$top = $top + $toplam;
			$_SESSION["top"] = $top;
		}
	}

	//[ Tablo  Bilgi  Bitiş]

	//[ Tablo Alt Bilgi]
	function FooterTable()
	{
		$this->Setfont('courier', 'B', 16);
		$this->Cell(70, 6, '', 1, 0, 'C');
		$this->Cell(60, 6, 'TOPLAM = ', 1, 0, 'C');
		$this->Cell(60, 6, $_SESSION["top"] . " TL", 1, 1, 'C');
	}
	//[ Tablo Alt Bilgi Bitiş]


	//[Alt Başlık]
	function Footer()
	{
		$this->SetY(-15);
		$this->SetX(-100);
		$this->Setfont('courier', 'i', 20);
		// $this->Cell(0, 0, 'TOPLAM GIDER: ', 0, 0, 'C');
	}
	//[Alt Başlık Bitiş]
}


$pdf = new PDF();
$pdf->AddPage('P', 'A4');
$pdf->HeaderTable();
$pdf->MainTable();
$pdf->FooterTable(); // Moved this line outside the MainTable() function
$pdf->Output();


?>