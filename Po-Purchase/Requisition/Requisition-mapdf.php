<?php
session_start();
// Include the PDF class
require_once "../../package/TCPDF-main/tcpdf.php";
date_default_timezone_set('Asia/Kolkata');


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {   

    //Page header
    public function Header() {
        include('../../includes/dbcon.php');
        $sql="SELECT * FROM Requisition_head where id='".$_GET['pdf']."'";
        $run=sqlsrv_query($conn,$sql);
        $row=sqlsrv_fetch_array($run,SQLSRV_FETCH_ASSOC);

    	$this->SetFont('times', 'B', 15);
        $this->Cell(0, 5, 'REQUISITION SLIP', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->SetFont("helvetica", "B", 10);
		$this->SetX(10);
		$this->Cell(0, 22, 'Indentor: - '.$row['indentor']);
        $this->SetX(235);
        $this->Cell(0, 22, 'Slip. No.: - '.$_GET['pdf']);
        $this->Ln(5);
        $this->SetX(10);
		$this->Cell(0, 25, 'Date: - '.$row['createdAt']->format('d-M-Y'));
		$this->SetX(235);
		$this->Cell(0, 25, 'Material Required Date:-'.$row['required_date']->format('d-M-Y'));
		$this->Ln(3);
		$this->SetX(5);
		$this->Cell(0, 25, '__________________________________________________________________________________________________________________________________________________');				

     
    }

    //Page footer
    public function Footer() {
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica','b', 8);
        $this->SetTextColor(153, 0, 0);
        /*$this->Cell(0, 10, '**This Is Computer Generated Report Signature Is Required**', 0, false, 'C', 0, '', 0, false, 'M', 'M');*/
        // Page number
       $this->Cell(0, 0, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}
// create new PDF document
$pdf = new MYPDF('P', 'mm', 'A3', true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('RequisitionSlip');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(1, 1, 5);//L T R
$pdf->SetHeaderMargin(3);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 2);
$pdf->AddPage();


$pdf->setPrintHeader(false);
// Logo
     
   

		//Set font
		$pdf->SetFont('helvetica', 'A2', 10);
		include('../includes/dbcon.php');
        $id= $_GET['pdf'];
      
		// $sql="SELECT From_Plant,To_Plant,Challanno,Date,No_of_core,corepair,ConductorType,Drum_No,Qnty,Stage,Name_of_contractor,Name,Sqmm FROM DShift where challanno='$id'";
        // $run=sqlsrv_query($conn,$sql);
        // $row=sqlsrv_fetch_array($run, SQLSRV_FETCH_ASSOC);

        // Store initial $row data
        // $initialRowData = $row;
        $sid=$_GET['pdf'];
        $sql1="SELECT from
         Requisition_details a.head_id,a.qnty,a.apx_cost,a.qnty*a.apx_cost as basic,a.department,a.mc,a.type,a.old_part_stat,b.item,b.category,b.item_code
         INNER JOIN [RM_software].[dbo].[rm_item]  b on a.item_code =b.i_code
         INNER JOIN Requisition_head c on c.id=a.head_id
         INNER JOIN [RM_software].[dbo].[rm_category] d on d.c_code=b.c_code
         where a.head_id ='$sid'";
        $run1=sqlsrv_query($conn,$sql1);
        $output = '<table style="width:100%; padding:4px;" border="1">
        <tr>
            <th><b>SR</b></th>
            <th><b>Item Description</b> </th>
            <th><b>Category</b></th>
            <th><b>Qnty</b></th>
            <th><b>aprx_Rate</b></th>
            <th><b>Basic_Val</b></th>
            <th><b>Dpt(mc)</b></th>
            <th><b>Type</b></th>
            <th><b>oldPartStatus</b></th>
            <th><b>Stock</b></th>
            <th><b>LP_Date</b></th>
            <th><b>LP_Rate</b></th>
            <th><b>Basic_Qnty</b></th>
        </tr>';
    while($row1=sqlsrv_fetch_array($run1,SQLSRV_FETCH_ASSOC)){
        $sql2="SELECT invoice_date,pur_rate,rec_qnty from inward_ind a
            LEFT OUTER JOIN inward_com b on a.sr_no = b.sr_no and a.receive_at = a.receive_at
            where p_item = '".$row1['item_code']."' order by invoice_date desc;
            $run2=sqlsrv_query($conn,$sql2);
            $row2=sqlsrv_fetch_array($run2,SQLSRV_FETCH_ASSOC);

    $output .='<tr>
                <td>'.$count.'</td>
                <td>'.$row1['item'].'</td>
                <td>'.$row1['category'].'</td>
                <td>'.$row1['qnty'].'</td>
                <td>'.$row1['apx_cost'].'</td>
                <td>'.$row1['basic'].'</td>
                <td>'.$row1['department'].'('.$row1['mc'].')'.</td>
                <td>'.$row1['type'].'</td>
                <td>'.$row1['old_part_stat'].'</td>
                <td>'.$row1[''].'</td>
                <td>'.$row2['invoice_date'].'</td>
                <td>'.$row2['pur_rate'].'</td>
                <td>'.$row2['rec_qnty'].'</td>
            </tr>';
    }
       

		$pdf->SetFont("helvetica", "A2", 10.5);						
		$pdf->SetY(27);
		$pdf->SetX(5);
		$pdf->writeHTML($output, true, false, false, false, 'C');


// Clean any content of the output buffer
ob_end_clean();

//Close and output PDF document
$pdf->Output('gatepass.pdf', 'I');

?>