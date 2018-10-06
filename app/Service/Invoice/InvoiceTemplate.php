<div style="font-size: 12px; ">
        <table style="padding-top: 20px">
                <tr style="text-align: left;">
                        <td style="width: 33.33%">
                                <table>

                                        <tr>
                                                <td>
                                                      <?php echo $receiver["name"] ?>
                                                </td>
                                        </tr>
                                        <tr>
                                                <td>
                                                <?php echo $receiver["street"] . " " . $receiver["house_number"] ?>
                                                </td>


                                        </tr>

                                        <tr>
                                                <td>
                                                <?php echo $receiver["zip_code"];
?>
                                                </td>


                                        </tr>
                                        <tr>
                                                <td>
                                                <?php if (isset($receiver["vat_number"])) {
    echo $receiver["vat_number"];
} ?>
                                                </td>

                                        </tr>
                                </table>

                        </td>
                        <td style="width: 33.33%;">
                        </td>
                        <td style="width: 33.33%;">
                                <table>

                                        <tr>
                                                <td>
                                                        Datum
                                                </td>
                                                <td>
                                                <?php echo $details["date"] ?>
                                                </td>
                                        </tr>
                                        <tr>
                                                <td>
                                                        Nummer
                                                </td>

                                                <td>
                                                <?php echo $details["number"] ?>
                                                </td>
                                        </tr>

                                </table>
                        </td>
                </tr>


                <tr style="text-align: left;">
                        <td style="width: 33.33%">

                        </td>
                        <td style="width: 33.33%;">
                        </td>
                        <td style="width: 33.33%;">
                                <table>

                                        <tr>
                                                <td>
                                                        Betrifft:
                                                </td>
                                        </tr>
                                        <tr>
                                                <td>
                                                <?php echo $details["topic"] ?>
                                                </td>
                                        </tr>
                                        <tr>
                                                <td>
                                                <?php echo $details["street"] . " " . $details["house_number"] ?>
                                                </td>
                                        </tr>

                                        <tr>
                                                <td>
                                                <?php echo $details["zip_code"] ?>
                                                </td>
                                        </tr>
                                </table>
                        </td>
                </tr>

                <tr>
                        <td>

                        </td>
                </tr>
        </table>

        <table style="text-align: left;">
                <tr>
                        <th style="width: 10%">
                                Pos.
                        </th>

                        <th style="width: 50%">
                                Beschreibung
                        </th>

                        <th style="width: 10%">
                                Anzahl
                        </th>
                        <th style="width: 10%">
                                ME
                        </th>

                        <th style style="width: 10%">
                                Preis
                        </th>

                        <th style="width: 10%">
                                Betrag
                        </th>
                </tr>

        <?php foreach ($items as $item) {
    echo "<tr>
                        <td>
                        ".$item["pos_num"]."
                        </td>

                        <td>
                        ".$item["descr"]."
                        </td>

                        <td>
                        ".$item["quantity"]." 
                        </td>

                        <td>
                        ".$item["me"]." 
                        </td>

                        <td>
                        ".$item["price"]."
                        </td>

                        <td>
                        ".$item["amount"]."
                        </td>

                </tr>";
}
        ?>
        </table>

        <table style="text-align: left">
                <tr>
                        <td style="width: 60%">

                                <h3>
                                        Zusätzliche Informationen:
                                </h3>

                                <?php echo $info ?>

                        </td>

                        <td style="width: 40%; text-align: right">
                                <table>
                                        <tr>
                                                <td>
                                                        Nettobetrag
                                                </td>

                                                <td>
                                                <?php echo $details["netto_sum"] ?>
                                                </td>
                                        </tr>
                                        <tr>
                                                <td>
                                                <?php echo $details["vat_percentage"] ?> MwSt
                                                </td>

                                                <td>
                                                <?php echo $details["vat_sum"] ?>
                                                </td>
                                        </tr>

                                        <tr>
                                                <td>
                                                        Gesamtbetrag
                                                </td>

                                                <td>
                                                <?php echo $details["brutto_sum"] ?>
                                                </td>
                                        </tr>

                                </table>
                        </td>
                </tr>


                <tr>
                        <td>

                        <h3> Zahlung: <?php
                                $string = $payment["days"] . " Tage nach Rechnungsdatum netto";
                                $payment["has_skonto"] ? $string.= ", innerhalb von " . $payment["days_skonto"] . " Tagen " . $payment["percent_skonto"] . "% Skonto." : $string.=".";
                                echo $string;
                                ?>
                        </h3>

                        </td>
                </tr>

                <tr>
                        <td>
                                <h3> Bankverbindung: </h3>
                        </td>
                </tr>
                <tr>
                        <td>
                        <?php echo $bank["bank"] ?>
                        </td>
                </tr>

                <tr>
                        <td>
                                BIC: <?php echo $bank["bic"] ?>
                        </td>
                </tr>

                <tr>
                        <td>
                                IBAN: <?php echo $bank["iban"] ?>
                        </td>
                </tr>

                <tr>
                        <td>
                                <h3> Kontakt </h3>
                        </td>
                </tr>

                <tr>
                        <td>
                        <?php echo $contact["tel"] ?>
                        </td>
                </tr>

                <tr>
                        <td>
                        <?php echo $contact["email"] ?>
                        </td>
                </tr>

                <tr>
                        <td>
                        <?php echo $contact["web"] ?>
                        </td>
                </tr>
        </table>



</div>