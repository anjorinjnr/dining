
<html>
    <head>

        <title>Neartutors</title>

        <meta content="text/html; charset=iso-8859-1" http-equiv="Content-Type" />
        <style type="text/css">
            .list a {color: #cc0000; text-transform: uppercase; font-family: Verdana; font-size: 11px; text-decoration: none;}

        </style>


    </head>
    <body marginheight="0" topmargin="0" marginwidth="0" bgcolor="#ffffff" leftmargin="0">

        <table cellspacing="0" border="0" style="background-color: #fff;" cellpadding="0" width="100%">

            <tr>

                <td valign="top">

                    <table cellspacing="0" border="0" align="center" style="background: #fff; margin-top:10px; cellpadding="0" width="600">
                        <tr> 
                            <td valign="top">
                                <!-- header -->
                                <table cellspacing="0" border="0" height="157" cellpadding="0" width="600">
                                    <tr>

                                        <td class="header-text" height="50" valign="top" style="color: #999; font-family: Verdana; font-size: 10px; text-transform: uppercase; padding: 5px 20px; border-bottom:4px solid #bababa;" width="540" colspan="2"><img src="http://neartutor.local/images/logo1-default.png" width="544" height="86"></td>

                                    </tr>
                                    <tr>
                                        <td class="main-title" height="13" valign="top" style="padding: 10px 20px; color:#1f75bf; font-size: 24px; font-family: Georgia; font-style: bold; border-bottom:1px solid #4e4e4e;" width="600" colspan="2">
                                            {{$subject}}</td>
                                    </tr>
                                </table>
                                <!-- / header -->
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:10px 20px; color:#3d3d3d; font-size:18px;">
                                Hello {{$first_name}}
                                click <a href="{{$root}}/user/activate/{{$activation_code}}/{{$encrypted_user_id}}">here</a>
                                to activate your account
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" width="600">
                                <!-- footer -->
                                <table cellspacing="0" border="0" height="202" cellpadding="0" width="600">
                                    <tr>
                                        <td valign="top">
                                            <table cellspacing="0" border="0" width="600" cellpadding="0" style="background-color:#4e4e4e;">
                                                <tr>
                                                    <td class="unsubscribe" valign="top" style="padding: 20px; color: #fff; font-size: 14px; font-family: Georgia; font-style:bold; line-height: 20px;" width="305">
                                                        This message was intended for {{$name}}, Please ignore message if you are not this person. 

                                                    </td>
                                                    <td valign="top" width="255">
                                                        <table cellspacing="0" width="255" cellpadding="0">
                                                            <tr>
                                                                <td valign="top">

                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="copyright" height="100" align="center" valign="top" style="padding: 0 20px; color: #1f75bf; font-family: Verdana; font-size: 10px; text-transform: uppercase; line-height: 20px;" width="600" colspan="2">
                                            www.neartutors.com</td>
                                    </tr>
                                </table>
                                <!-- / end footer -->
                            </td>
                        </tr>
                    </table>

                </td>

            </tr>

        </table>

    </body>
</html>
