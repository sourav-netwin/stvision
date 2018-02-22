<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('writehtmltopdf'))
{
        /**
        * writehtmltopdf
        *
        * convert html to pdf file
        *
        * @param string $html html for pdf
        * @param string $filename filename without extension
        * @param string $savePath store path optional
        * @return	pdf content
        * @access   public
        * @author   SK
        */
	function writehtmltopdf($html,$filename = 'samplepdf.pdf',$savePath = SENT_JOB_OFFER_PATH)
	{
            include_once("mpdf60/mpdf.php"); // load mpdf
            $mpdf= new mPDF('utf-8', 'A4');
            $mpdf->WriteHTML($html);
            $mpdf->Output($savePath.$filename.'.pdf','D'); // write to pdf file, see pdf/ dir at root
           
            //exit;
            /*
             $mpdf = new mPDF('',    // mode - default ''
                 '',    // format - A4, for example, default ''
                 0,     // font size - default 0
                 '',    // default font family
                 15,    // margin_left
                 15,    // margin right
                 16,     // margin top
                 16,    // margin bottom
                 9,     // margin header
                 9,     // margin footer
                 'L');  // L - landscape, P - portrait

            */
	}
}

if ( ! function_exists('writeHtmlPdfAndSave'))
{
    function writeHtmlPdfAndSave($html,$filename = 'samplepdf.pdf',$savePath = SENT_JOB_OFFER_PATH,$addPlusedHeader = false)
    {
        include_once("mpdf60/mpdf.php"); // load mpdf
        $mpdf= new mPDF('utf-8', 'A4');
        if($addPlusedHeader)
        {
            $htmlHeader = "<div style='background-color:#ffffff; color:#0265A3;'><div style='float: left;width:210px;' ><img src='http://plus-ed.com/vision_ag/img/tuition/logo.png' alt=''/></div><div style='width: 420px;font-size: 20px;font-weight: bold;padding-top:15px;'>PLUS Summer School</div></div>";
            $mpdf->setAutoTopMargin = "stretch";
            $mpdf->SetHTMLHeader($htmlHeader);
        }
        $mpdf->WriteHTML($html);
        $mpdf->Output($savePath.$filename.'.pdf','F'); // write to pdf file, see pdf/ dir at root
    }
}

if (!function_exists('isItValidDate')) {

    /**
     * isItValidDate
     * This function can be use to check is it a valid date or not
     * @param date $date
     * @param string $dateFormat
     * @return boolean
     * @author SK
     * @since Apr 2016
     */
    function isItValidDate($date,$dateFormat = "Y-m-d") {

        switch ($dateFormat)
        {

            case "Y-m-d": // YYYY-MM-DD Format
                $date = date("Y-m-d",  strtotime($dateFormat));
                    if (preg_match("/^(\d{4})-(\d{2})-(\d{2})$/", $date, $matches))
                    {
                        if (checkdate($matches[2], $matches[3], $matches[1])) {
                            return true;
                        }
                    }
                break;
            case "d/m/Y": // DD/MM/YYYY Format
                if(preg_match("/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/", $date, $matches))
                {
                    if(checkdate($matches[2], $matches[1], $matches[3]))
                    {
                        return true;
                    }
                }
                break;
            case "m-d-Y": // MM-DD-YYYY Format
                if(preg_match("/^(\d{2})-(\d{2})-(\d{4})$/", $date, $matches))
                {
                    if(checkdate($matches[1], $matches[2], $matches[3]))
                    {
                        return true;
                    }
                }
                break;
            default :
                if (preg_match("/^(\d{4})-(\d{2})-(\d{2})$/", $date, $matches))
                    {
                        if (checkdate($matches[2], $matches[3], $matches[1])) {
                            return true;
                        }
                    }
                break;
        }
        return false;
    }

}

if ( ! function_exists('printDate'))
{
    /**
     * printDate
     * This function can be use to check if the date is valid or not
     * if its valid it returns valid date in requested format or return empty
     * @param date $dateToPrint
     * @param string $returnFormat
     * @param string $checkFormat
     * @return string
     * @author SK
     * @since Apr 2016
     */
    function printDate($dateToPrint,$returnFormat = "Y-m-d",$checkFormat = "Y-m-d")
    {
        
        if($dateToPrint == "0000-00-00 00:00:00" || empty($dateToPrint))
            return "";
        else if(isItValidDate($dateToPrint,$checkFormat))
        {
            return date($returnFormat,strtotime ($dateToPrint));
        }
        else
            return "";
    }
}

if ( ! function_exists('noSpecialChars'))
{
    function noSpecialChars($strInput){
        if(preg_match("/([%\$#\*]+)/", $strInput))
            return false;
        else
            return true;
    }
}


if ( ! function_exists('getStudentListColor'))
{
    /**
     * This function returns proper color code for students listing according to their knowledge lang.
     * @param type $languageKnowledge
     * @return string 
     */
    function getStudentListColor($languageKnowledge){
        if($languageKnowledge >= 1 && $languageKnowledge <= 33){
            return "#73E0FD";
        }
        elseif($languageKnowledge >= 34 && $languageKnowledge <= 50){
            return "#B3F8AE";
        }
        elseif($languageKnowledge >= 51 && $languageKnowledge <= 66){
            return "#FCFDB0";
        }
        elseif($languageKnowledge >= 67 && $languageKnowledge <= 83){
            return "#F6D2AD";
        }
        elseif($languageKnowledge >= 84 && $languageKnowledge <= 100){
            return "#FD9BAD";
        }
    }
}

if ( ! function_exists('downloadhtmltopdf'))
{
        /**
        * downloadhtmltopdf
        *
        * download html as pdf file
        *
        * @param string $html html for pdf
        * @param string $filename filename without extension
        * @return   pdf file download
        * @access   public
        * @author   Preeti M
        */
    function downloadhtmltopdf( $html, $filename = 'samplepdf.pdf' )
    {
        include_once("mpdf60/mpdf.php"); // load mpdf
        $mpdf= new mPDF('utf-8', 'A4');
        $mpdf->WriteHTML( $html );
        $mpdf->Output( $filename.'.pdf','D' );
    }
}


if ( ! function_exists('writeHtmlPdfAndSaveSingleVisas'))
{
    function writeHtmlPdfAndSaveSingleVisas($html,$filename = 'samplepdf.pdf',$addPlusedHeader = true, $template = '')
    {
        include_once("mpdf60/mpdf.php"); // load mpdf
        $mpdf= new mPDF('utf-8', 'A4',10,0,0,0,2,15,2,0,'P');
        if($addPlusedHeader)
        {
            if($template != 'MAL'){
                $htmlHeader = '
                <table style="margin:0 auto;margin-top:5px;">
                                <tr>
                                    <td>
                                        <table>
                                            <tr>
                                                <td><img src="http://plus-ed.com/vision_ag/img/logo_plus.png" width=150></td>
                                            </tr>
                                            <tr style="color: #035082;font-weight: 700;">
                                                <td style="color: #035082;font-weight: 700;font-size:10px">Professional Linguistic & Upper Studies<br> Part of PLUS Group Ltd</td>
                                            </tr>
                                        </table>
                                        
                                        
                                    </td>
                                    <td>
                                    <table style="border-bottom: 1px solid #035082;color: #035082;">
                                        <tr >
                                        <td style="padding-right: 40px !important;font-size: 12px !important;padding-left: 40px !important;">London</td>
                                        <td style="padding-right: 40px !important;font-size: 12px !important;">Dublin</td>
                                        <td style="padding-right: 40px !important;font-size: 12px !important;">New York</td>
                                        <td style="padding-right: 40px !important;font-size: 12px !important;">Milan</td>
                                        </tr>
                                    </table>
                                    </td>
                                </tr>
                            </table>
                
                ';
            }
            else{
                $htmlHeader = '';
            }

            $htmlfooter = '
                <div class="pdf-footer" style="text-align: center; color: #005dc7; font-weight: bold: padding: 10px;font-size:12px;margin-top:3px;">
					<p class="page" style="padding: 5px;">Plus-8-10 Grosvenor Gardens, Mezzanine floor, London, SW1W 0DH-P: +44(0)20 7730 2223 - F: +44 (0)20 7730 9209 - E: info@plus-ed.com </p>
					<p style="background-color: #005dc7; color: #fff !important;padding: 5px;">
						Registered Office: 8-10 Grosvenor Gardens, London SW1W 0DH - Reg. No. 2965176 - www.plus-ed.com 
					</p>
				</div>
            ';
            $mpdf->setAutoTopMargin = "stretch";
            $mpdf->SetHTMLHeader($htmlHeader);
            $mpdf->SetHTMLFooter ($htmlfooter);
        }
        $mpdf->SetDisplayMode('fullwidth');
        $mpdf->WriteHTML($html);
        $mpdf->Output( $filename.'.pdf','I' );// write to pdf file, see pdf/ dir at root
    }
}


if ( ! function_exists('writeHtmlPdfAndSaveJobContract'))
{
    function writeHtmlPdfAndSaveJobContract($html,$filename = 'samplepdf.pdf',$savePath = ACADEMIC_CONTRACT_FILE_PATH)
    {
        include_once("mpdf60/mpdf.php"); // load mpdf
        $mpdf= new mPDF('utf-8', 'A4',10,0,0,0,2,15,2,0,'P');
        
        $htmlHeader = '
        <table style="margin:0 auto;margin-top:5px;">
                        <tr>
                            <td>
                                <table>
                                    <tr>
                                        <td><img src="http://plus-ed.com/vision_ag/img/logo_plus.png" width=150></td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                            <table style="border-bottom: 1px solid #035082;color: #035082;">
                                <tr >
                                <td style="padding-right: 40px !important;font-size: 12px !important;padding-left: 40px !important;">London</td>
                                <td style="padding-right: 40px !important;font-size: 12px !important;">New York</td>
                                <td style="padding-right: 40px !important;font-size: 12px !important;">Milan</td>
                                </tr>
                            </table>
                            </td>
                        </tr>
                    </table>

        ';

        $htmlfooter = '
            <div class="pdf-footer" style="text-align: center; color: #005dc7; font-weight: bold: padding: 10px;font-size:12px;margin-top:3px;">
                                    <p class="page" style="padding: 5px;">Professional Linguistic & Upper Studies Limited t/a PLUS - P: + 44 (0)20 7730 2223 - E: info@plus-ed.com</p>
                                    <p style="background-color: #005dc7; color: #fff !important;padding: 5px;">
                                            Registered Office: 8-10 Grosvenor Gardens, London SW1W 0DH - Reg. No. 2965176 - www.plus-ed.com 
                                    </p>
                            </div>
        ';
        $mpdf->setAutoTopMargin = "stretch";
        $mpdf->SetHTMLHeader($htmlHeader);
        $mpdf->SetHTMLFooter ($htmlfooter);
        
        $mpdf->SetDisplayMode('fullwidth');
        $mpdf->WriteHTML($html);
        $mpdf->Output( $savePath . $filename.'.pdf','F' );// write to pdf file, see pdf/ dir at root
    }
}