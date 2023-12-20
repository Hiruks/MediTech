<?php

class Reports extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }

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
