$(document).ready(function () {
    $('#keyword').on('input', function () {
        var searchKeyword = $(this).val();
        $('#name').val('');
        getEmployeeData(searchKeyword, 'epf_no');
    });

    $('#name').on('input', function () {
        var searchKeyword = $(this).val();
        $('#keyword').val('');
        getEmployeeData(searchKeyword, 'name');
    });
    function getEmployeeData($key, $LIKE) {
        var searchKeyword = $key;
        //table information
        $table_Name = 'employee';
        $fields = 'employee.name,employee.epf_no,employee.appoinment_date,employee.nic,employee.dob,employee.address,employee.contact,designation.designation';
        $join = 'designation ON employee.designation = number';
        $where = "" + $LIKE + " LIKE '%" + searchKeyword + "%'";
        $orderBy = 'serial_no ASC';

        $dataString = {keywords: searchKeyword, table_Name: $table_Name, fields: $fields, join: $join, where: $where, orderBy: $orderBy};
        if (searchKeyword.length >= 1) {
            $.ajax({
                url: '../assets/search.php',
                type: 'post',
                data: $dataString,
                dataType: "json",
                cache: false,
                async: false,
                success: function (data) {
                    $('table#dataTable  tbody').empty()
                    //$('table#dataTable  tbody').append(data.name);
                    $.each(data, function () {
                        content = '<tr><td>' + this.name + '</td>';
                        content += '<td>' + this.designation + '</td>';
                        content += '<td>' + this.epf_no + '</td>';
                        content += '<td>' + this.appoinment_date + '</td>';
                        content += '<td>' + this.nic + '</td>';
                        content += '<td>' + this.dob + '</td>';
                        content += '<td>' + this.address + '</td>';
                        content += '<td>' + this.contact + '</td></tr>';
                        $('table#dataTable  tbody').append(content);
                    });
                }
            });
        }
    }

    $('#projectID').on('input', function () {
        var searchKeyword = $(this).val();
        $('#projectName').val('');
        getConstructionData(searchKeyword, 'contractNo');
    });
    $('#projectName').on('input', function () {
        var searchKeyword = $(this).val();
        $('#projectID').val('');
        getConstructionData(searchKeyword, 'projectName');
    });
    function getConstructionData($key, $LIKE) {
        var searchKeyword = $key;
        //table information
        $table_Name = 'contractdetails e, clients c ';
        $fields = 'c.name, c.address, e.*';
        $join = null;
        $where = "e.client = c.id AND " + $LIKE + " LIKE '%" + searchKeyword + "%'";
        $orderBy = null;

        $dataString = {keywords: searchKeyword, table_Name: $table_Name, fields: $fields, join: $join, where: $where, orderBy: $orderBy};
        if (searchKeyword.length >= 1) {
            $.ajax({
                url: '../assets/search.php',
                type: 'post',
                data: $dataString,
                dataType: "json",
                cache: false,
                async: false,
                success: function (data) {
                    $('table#dataTable  tbody').empty()
                    //$('table#dataTable  tbody').append(data.name);
                    $.each(data, function () {
                        var total = parseFloat(this.contractSum) + parseFloat(this.extendedContractSum);
                        content = '<tr><td>' + this.id + '</td>';
                        content += '<td>' + this.contractNo + '</td>';
                        content += '<td>' + this.projectName + '</td>';
                        content += '<td>' + this.name + '</td>';
                        content += '<td>' + this.progress + '</td>';
                        content += '<td>' + this.commencementDate + '</td>';
                        content += '<td>' + this.completionDate + '</td>';
                        content += '<td>' + this.extendedDate + '</td>';
                        content += '<td>' + this.contractPeriod + '</td>';
                        content += '<td>' + this.contractSum + '</td>';
                        content += '<td>' + this.extendedContractSum + '</td>';
                        content += '<td>' + total.toFixed(2) + '</td></tr>';
                        $('table#dataTable  tbody').append(content);
                    });
                }
            });
        }
    }
// Resigned Employee =============================================================================
    $('#epfResigned').on('input', function () {
        var searchKeyword = $(this).val();
        $('#name').val('');
        getEmpResData(searchKeyword, 'epf_no');
    });

    $('#nameResigned').on('input', function () {
        var searchKeyword = $(this).val();
        $('#keyword').val('');
        getEmpResData(searchKeyword, 'name');
    });
    function getEmpResData($key, $LIKE) {
        var searchKeyword = $key;
        //table information
        $table_Name = 'resignold';
        $fields = 'resignold.name,resignold.epf_no,resignold.appoinment_date,resignold.nic,resignold.dob,resignold.address,resignold.contact,designation.designation';
        $join = 'designation ON resignold.designation = number';
        $where = "" + $LIKE + " LIKE '%" + searchKeyword + "%'";
        $orderBy = 'serial_no ASC';

        $dataString = {keywords: searchKeyword, table_Name: $table_Name, fields: $fields, join: $join, where: $where, orderBy: $orderBy};
        if (searchKeyword.length >= 1) {
            $.ajax({
                url: '../assets/search.php',
                type: 'post',
                data: $dataString,
                dataType: "json",
                cache: false,
                async: false,
                success: function (data) {
                    $('table#dataTable  tbody').empty()
                    //$('table#dataTable  tbody').append(data.name);
                    $.each(data, function () {
                        content = '<tr><td>' + this.name + '</td>';
                        content += '<td>' + this.designation + '</td>';
                        content += '<td>' + this.epf_no + '</td>';
                        content += '<td>' + this.appoinment_date + '</td>';
                        content += '<td>' + this.nic + '</td>';
                        content += '<td>' + this.dob + '</td>';
                        content += '<td>' + this.address + '</td>';
                        content += '<td>' + this.contact + '</td></tr>';
                        $('table#dataTable  tbody').append(content);
                    });
                }
            });
        }
    }
//========================================================================================
//machine details search
// Resigned Employee =============================================================================
    $('#machine').on('input', function () {
        var searchKeyword = $(this).val();
        getmachin(searchKeyword, 'machineName');
    });
    function getmachin($key, $LIKE) {
        var searchKeyword = $key;
        //table information
//        $table_Name = 'resignold';
//        $fields = 'resignold.name,resignold.epf_no,resignold.appoinment_date,resignold.nic,resignold.dob,resignold.address,resignold.contact,designation.designation';
//        $join = 'designation ON resignold.designation = number';
//        $where = "" + $LIKE + " LIKE '%" + searchKeyword + "%'";
//        $orderBy = 'serial_no ASC';

        $table_Name = 'machine m, machinebrand b, machinesite s, machineName n';
        $fields = 'm.*, b.*, s.*, n.*';
        $join = null;
        $where = 'm.brand = b.brandNo AND m.siteName = s.siteNo AND n.nameIdMachine = m.nameId AND ' + $LIKE + ' LIKE "%' + searchKeyword + '%" ';
        $orderBy = 'm.id ASC';

        $dataString = {keywords: searchKeyword, table_Name: $table_Name, fields: $fields, join: $join, where: $where, orderBy: $orderBy};
        if (searchKeyword.length >= 1) {
            $.ajax({
                url: '../assets/search.php',
                type: 'post',
                data: $dataString,
                dataType: "json",
                cache: false,
                async: false,
                success: function (data) {
                    $('table#dataTable  tbody').empty()
                    //$('table#dataTable  tbody').append(data.name);
                    $.each(data, function () {
                        content = '<tr><td>' + this.id + '</td>';
                        content += '<td>' + this.machineCategory + '</td>';
                        content += '<td>' + this.machineNo + '</td>';
                        content += '<td>' + "<a href='addEditMachine.php?id="+this.id+" ' class='btn btn-xs btn-info left-margin'>"+this.machineName+"</a>"+  '</td>';
                        content += '<td>' + this.brandName + '</td>';
                        content += '<td>' + this.model + '</td>';
                        content += '<td>' + this.siteN + '</td>';
                        content += '<td>' + "<a href='addEditMachine.php?id="+this.id+" ' class='btn btn-xs btn-warning left-margin'>Edit</a>\n\
                    <a delete-id="+this.id+" class='btn btn-xs btn-danger delete-object'>Delete</a>" +'</td></tr>';
                        $('table#dataTable  tbody').append(content);
                    });
                }
            });
        }
    }
});
