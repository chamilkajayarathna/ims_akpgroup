<?php
require ('../../core/init.php');

if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
} else {
    if (empty($_SESSION['id'])) {
        header('Location:' . $global->wwwroot . 'application/login/login.php');
    }
}
if (!empty($_POST['ddlID'])) {
    $ddlSelectedID = $_POST['ddlID'];

    $machineService = $dbCRUD->ddlDataLoad('SELECT m.machineName,m.nameId, s.* FROM machine m, machineservice s WHERE m.id = s.machineID AND s.machineID =' . $ddlSelectedID);

    $html = "<table class='table table-striped table-hover table-responsive table-bordered'><thead>
				<tr>
                	<th>Machine</th>
                    <th>Last Service</th>
                    <th>Next Service</th>
                    <th>Mechanic</th>
                    <th>Operator</th>
                    <th>Date</th>
                    <th>Details</th>
                    <th>Action</th>
                </tr></thead>";
    if (!empty($machineService)) {
        foreach ($machineService as $service) {
            $id = $service['machineID'];
            $machineName = $service['machineName'];
            $lastService = $service['lastService'];
            $nextService = $service['nextService'];
            $mechanic = $service['mechanic'];
            $operator = $service['operator'];
            $date = $service['date'];
            $srvdetails = $service['srvdetails'];
            $html .= "<tr>
					<td>" . $machineName . "</td>
					<td>" . $lastService . "</td>
					<td>" . $nextService . "</td>
					<td>" . $mechanic . "</td>
					<td>" . $operator . "</td>
					<td>" . $date . "</td>
					<td>" . $srvdetails . "</td>
                                        <td><a href='machineDetails.php?id=$id' class='btn btn-xs btn-warning left-margin'>View Details</a></td>
				</tr>";
        }
    } else {
        $machineName = "";
        $lastService = "";
        $nextService = "";
        $mechanic = "";
        $operator = "";
        $date = "";
        $filters = "";
        $srvdetails = "";
        $html .= "<tr>
					<td colspan='8' align='center'> --- No Service Records Found ---</td>
				</tr>";
    }
    $html .= "</table>";
    die($html);
}
?>