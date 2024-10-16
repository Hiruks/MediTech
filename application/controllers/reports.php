<?php

class Reports extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }

    public function customerPdf()
    {
        // Load Bootstrap CSS content
        $bootstrapCss = file_get_contents("http://localhost/MediTech/css/bootstrap.min.css");
        $customCss = file_get_contents("http://localhost/MediTech/css/custom/public-dashboard.css");

        $result = $this->user_model->fetchCustomerDB();

        $html = "<html>
                <head>
                    <style>
                        {$bootstrapCss}
                        {$customCss}
                        body {
                            font-size: 14px;
                        }
                        .mt-4 {
                            margin-top: 1rem !important;
                        }
                        .innercont {
                            margin: 1rem !important;
                            padding: 1rem;
                        }
                        .table {
                            width: 100%;
                            margin-bottom: 1rem;
                            color: #212529;
                            background-color: transparent;
                        }
                        .table-bordered {
                            border: 1px solid #dee2e6;
                        }
                        .table-bordered th, .table-bordered td {
                            border: 1px solid #dee2e6;
                        }
                        .table-striped tbody tr:nth-of-type(odd) {
                            background-color: rgba(0, 0, 0, 0.05);
                        }
                        .thead-dark th {
                            color: #fff;
                            background-color: #343a40;
                        }
                        .text-danger {
                            color: #dc3545 !important;
                        }
                        .text-success {
                            color: #28a745 !important;
                        }
                    </style>
                </head>
                <body>
                    <div class='mt-4 innercont p-5'>
                        <table class='table table-striped'>
                            <thead class='thead-dark'>
                                <tr>
                                    <th>Customer ID</th>
                                    <th>Customer Name</th>
                                    <th>Email</th>
                                    <th>Contact Number</th>
                                    <th>Status</th>
                                    <th>Registered Date</th>
                                </tr>
                            </thead>
                            <tbody>";

        foreach ($result as $customer) {
            $statusClass = ($customer->status == "blacklisted") ? "text-danger" : "text-success";

            $html .= "<tr>
                        <td>{$customer->custID}</td>
                        <td>{$customer->name}</td>
                        <td>{$customer->email}</td>
                        <td>{$customer->contactNo}</td>
                        <td class='{$statusClass}'>{$customer->status}</td>
                        <td>{$customer->registered_date}</td>
                    </tr>";
        }

        $html .= "</tbody></table></div></body></html>";
        
        //dompdf

        $customPaper = array(0, 0, 800, 700);
        
        $this->load->library('pdf');
        
        $this->pdf->loadHtml($html);
        $this->pdf->setPaper($customPaper, 'landscape');
        $this->pdf->render();
        $this->pdf->stream("sample.pdf", array("Attachment" => 0)); 
        
=======
    public function showPdf()
    {
        $result = $this->user_model->fetchCustomerDB();

        $html = "<div class=' mt-4 innercont p-5 me-4'>

        <table class='table'>

            <thead>
                <tr>
                    <th>Customer ID</th>
                    <th>Customer Name</th>
                    <th>Email</th>
                    <th>Contact Number</th>
                    <th>Status</th>
                    <th>Registered Date</th>
                </tr>
            </thead>

            <tbody>";
        foreach ($result as $customer) {
            $html .= "<tr>
            <td>{$customer->custID}</td>
            <td>{$customer->name}</td>
            <td>{$customer->email}</td>
            <td>{$customer->contactNo}</td>
            <td class='";

            if ($customer->status == "blacklisted") {
                $html .= "text-danger'>blacklisted</td>";
            } else {
                $html .= "text-success'>whitelisted</td>";
            }
            $html .= "<td>{$customer->registered_date}</td></tbody></table></div>";
        }
//print $html;
        $customePaper = array(0, 0, 500, 500);
        $this->load->library('pdf');

        $this->pdf->loadHtml($html); // load all html and css contents in view
        // $this->dompdf->setPaper('A4', 'landscape');
        // $this->dompdf->setPaper('A4', 'portrait');
        $this->pdf->setPaper('A4', 'landscape'); // set pdf paper size and orientation
        $this->pdf->render(); // its convert all html & css elements to pdf
        $this->pdf->stream("sample.pdf", array("Attachment" => 0)); //used to output generated in broswer and its automatically download the pdf

        $currentMonth = date('n');
                //$currentMonth = 11;

                redirect('login/dashboard/' . $currentMonth);

    }
}
