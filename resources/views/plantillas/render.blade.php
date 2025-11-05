<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:v="urn:schemas-microsoft-com:vml"
      xmlns:o="urn:schemas-microsoft-com:office:office"
      lang="es-ES">
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;" />
  <!--[if gte mso 9]>
  <xml>
    <o:OfficeDocumentSettings>
      <o:AllowPNG/>
      <o:PixelsPerInch>96</o:PixelsPerInch>
    </o:OfficeDocumentSettings>
  </xml>
  <![endif]-->
  <style>
      html{width:100%;}
      body{width:100% !important;margin:0 auto !important; padding:0!important}
      .m_ExternalClass * {line-height:100%;}
      .ExternalClass * {line-height: 100%}
      table td {border-collapse: collapse;}
      table { border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
      a{color:#2354FF;text-decoration:none;}
      a[x-apple-data-detectors] {
        color: inherit !important;
        text-decoration: none !important;
        font-size: inherit !important;
        font-family: inherit !important;
        font-weight: inherit !important;
        line-height: inherit !important;
      }
      .boton {
        -webkit-box-shadow: none;
        -moz-box-shadow: none;
        box-shadow: none;
      }

      /* MOBILE STYLES */
      @media only screen and (max-width:600px) {
        .full-width {width:100%!important;text-align:center!important;}
        .m_top20 {padding-top:20px!important;}
        .m_lat0 {padding-left:0!important;padding-right:0!important;}
        .hiddenmobile {display:none!important;}
        .boton {font-size:15px!important;width:auto!important;}
      }

      /* Tus estilos personalizados adicionales */
      {!! $styles ?? '' !!}
  </style>
</head>
<body>
  {{-- Recorrer todas las secciones renderizadas --}}

  @foreach ($sections as $section)
      {!! $section['html'] !!}
  @endforeach
</body>
</html>