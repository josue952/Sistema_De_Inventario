<?php

require('./fpdf.php');

class PDF extends FPDF
{

   // Cabecera de página
   function Header()
   {
      include '../../Conexion-Base-de-Datos/dbConexionReportes.php';//llamamos a la conexion BD
      //Consulta para obtener los datos de la empresa
      $sqlEmpresa = $conexion->query(" SELECT * FROM empresa ");//traemos datos de la empresa desde BD
      $datosEmpresa = $sqlEmpresa->fetch_assoc();

      //Datos de la empresa
      $nombreEmpresa = utf8_decode($datosEmpresa['NombreEmpresa']);
      $sloganEmpresa = utf8_decode($datosEmpresa['SloganEmpresa']);
      $logoEmpresa = utf8_decode($datosEmpresa['LogoEmpresa']);

      //$dato_info = $consulta_info->fetch_object();
      $this->Image('../../'.$logoEmpresa.'', 175, 5, 18); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
      $this->SetFont('Arial', 'B', 19); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(45); // Movernos a la derecha
      $this->SetTextColor(0, 0, 0); //color
      //creamos una celda o fila
      $this->Cell(110, 15, utf8_decode($nombreEmpresa), 1, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
      $this->Ln(3); // Salto de línea
      $this->SetTextColor(103); //color

      //creamos una celda o fila
      $this->Cell(200, 15, utf8_decode($sloganEmpresa), 0, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
      $this->Ln(3); // Salto de línea
      $this->SetTextColor(103); //color


      /* TITULO DE LA TABLA */
      //color
      $this->SetTextColor(0, 0, 0);//color en RGB
      $this->Cell(50); // mover a la derecha
      $this->SetFont('Arial', 'B', 15);
      $this->Cell(100, 10, utf8_decode("REPORTE DE CATEGORIAS"), 0, 1, 'C', 0);
      $this->Ln(7);

      /* CAMPOS DE LA TABLA */
      //color
      $this->SetFillColor(48, 156, 222); //colorFondo
      $this->SetTextColor(255, 255, 255); //colorTexto
      $this->SetDrawColor(163, 163, 163); //colorBorde
      $this->SetFont('Arial', 'B', 11);
      $this->Cell(20, 8, utf8_decode('ID'), 1, 0, 'C', 1);
      $this->Cell(40, 8, utf8_decode('CATEGORIA'), 1, 0, 'C', 1);
      $this->Cell(65, 8, utf8_decode('DESCRIPCION'), 1, 0, 'C', 1);
      $this->Cell(60, 8, utf8_decode('METODO DE INVENTARIO'), 1, 0, 'C', 1);
      $this->Ln(8);
   }

   // Pie de página
   function Footer()
   {
      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C'); //pie de pagina(numero de pagina)

      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, cursiva, tamañoTexto
      $hoy = date('d/m/Y');
      $this->Cell(355, 10, utf8_decode($hoy), 0, 0, 'C'); // pie de pagina(fecha de pagina)
   }
}

include '../../Conexion-Base-de-Datos//dbConexionReportes.php';

/* CONSULTA INFORMACION DEL HOSPEDAJE */
$sqlUsuarios = $conexion->query(" SELECT * FROM categorias ");//traemos datos de la empresa desde BD

$pdf = new PDF();
$pdf->AddPage(); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas

$pdf->SetFont('Arial', '', 10);
$pdf->SetDrawColor(163, 163, 163); //colorBorde

while ($row = $sqlUsuarios->fetch_object()) {
   $pdf->Cell(20, 8, utf8_decode($row->idCategoria), 1, 0, 'C', 0);
   $pdf->Cell(40, 8, utf8_decode($row->Categoria), 1, 0, 'C', 0);
   $pdf->Cell(65, 8, utf8_decode($row->Descripcion), 1, 0, 'C', 0);
   $pdf->Cell(60, 8, utf8_decode($row->MetodoInventario), 1, 0, 'C', 0);
   $pdf->Ln(8);
}

$pdf->Output('ReporteCategorias.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)
