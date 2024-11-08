<?php
session_start();

if (!isset($_SESSION['user_name']) && !isset($_SESSION['name'])) {
    header('location:loginpage.php');
}

if (isset($_POST['edit_id5'])) {
    $eid = $_POST['edit_id5'];
    
    $con = mysqli_connect("localhost", "Anika12", "Anika12", "ems");
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM payroll_msalarystruc 
    INNER JOIN payroll_asalarystruc ON payroll_msalarystruc.empname = payroll_asalarystruc.empname 
    WHERE payroll_msalarystruc.empname = ?";

    $query = $con->prepare($sql);
    $query->bind_param('s', $eid); 
    $query->execute();
    $result = $query->get_result();
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <div class="section active" id="section1" style="scale: 0.9; margin-left: -50px; margin-top: -100px;">
            <div style="position: absolute; ">
                <p style="text-align: center; font-size: 25px; padding-top: 20px;">Monthly Component</p>
                <!-- Salary Details -->
                <div>
                    <p style="margin-left: 20px; margin-top: 10px;">Salary Details:</p>
                    <div style="display: flex; margin-top: 10px;">
                        <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Gross Salary (CTC):</label>
                        <div style="display: flex; margin-left: 20px;">
                            <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                            <input type="text" value="<?php echo $row['ctc']; ?>" style="font-size: 18px; width: 300px; height: 40px; border: 1px solid rgb(185,185,185);">
                            <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                        </div>
                    </div>
                    <div style="display: flex; margin-top: 10px;">
                        <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Basic Pay:</label>
                        <div style="display: flex; margin-left: 86px;">
                            <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                            <input type="text" value="<?php echo $row['abp']; ?>"  style="font-size: 18px; width: 300px; height: 40px; border: 1px solid rgb(185,185,185);">
                            <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                        </div>
                    </div>
                    <div style="display: flex; margin-top: 10px;">
                        <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">HRA:</label>
                        <div style="display: flex; margin-left: 130px;">
                            <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                            <input type="text" value="<?php echo $row['hra']; ?>"  style="font-size: 18px; width: 300px; height: 40px; border: 1px solid rgb(185,185,185);">
                            <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                        </div>
                    </div>
                    <div style="display: flex; margin-top: 10px;">
                        <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Other Allowances:</label>
                        <div style="display: flex; margin-left: 25px;">
                            <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                            <input type="text" value="<?php echo $row['oa']; ?>"  style="font-size: 18px; width: 300px; height: 40px; border: 1px solid rgb(185,185,185);">
                            <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                        </div>
                    </div>

                </div>
                <!-- Deductions on Basic pay -->
                <div>
                    <p style="margin-left: 20px; margin-top: 10px;">Deductions on Basic pay:</p>
                    <!-- <img src="./public/infosym.png" width="20px" alt="" style="margin-left: 260px; margin-top: -20px;"> -->
                    <div style="display: flex; margin-top: 10px;">
                        <div style="display: flex;">
                            <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">EPF:</label>
                            <div style="display: flex; margin-left: 40px;">
                                <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                <input type="text" value="<?php echo $row['epf1']; ?>"  style="font-size: 18px; width: 150px; height: 40px; border: 1px solid rgb(185,185,185);">
                                <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                            </div>
                        </div>
                        <div style="display: flex;">
                            <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">ESI:</label>
                            <div style="display: flex; margin-left: 70px;">
                                <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                <input type="text" value="<?php echo $row['esi1']; ?>"  style="font-size: 18px; width: 150px; height: 40px; border: 1px solid rgb(185,185,185);">
                                <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                            </div>
                        </div>
                    </div>
                    <!-- <p style="margin-left: 20px; font-weight: lighter; font-size: 15px; margin-top: 10px; color: #F46114;">ESI deductions applicable only if gross salary is more than 21000</p> -->
                </div>
                <!-- Employer share EPF -->
                <div>
                    <p style="margin-left: 20px; margin-top: 10px;">Employer Share on EPF:</p>
                    <!-- <img src="./public/infosym.png" width="20px" alt="" style="margin-left: 250px; margin-top: -20px;"> -->
                    <div style="display: flex; margin-top: 10px;">
                        <div style="display: flex;">
                            <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Pension:</label>
                            <div style="display: flex; margin-left: 10px;">
                                <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                <input type="text" value="<?php echo $row['epf2']; ?>"  style="font-size: 18px; width: 150px; height: 40px; border: 1px solid rgb(185,185,185);">
                                <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                            </div>
                        </div>
                        <div style="display: flex;">
                            <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">EPF Share:</label>
                            <div style="display: flex; margin-left: 10px;">
                                <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                <input type="text" value="<?php echo $row['epf3']; ?>"  style="font-size: 18px; width: 150px; height: 40px; border: 1px solid rgb(185,185,185);">
                                <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                            </div>
                        </div>
                    </div>
                    <!-- <p style="margin-left: 20px; font-weight: lighter; font-size: 15px; margin-top: 10px; color: #F46114;">Total Employer share on EPF is 12%</p> -->
                </div>
                <!-- Employer share ESI -->
                <div>
                    <p style="margin-left: 20px; margin-top: 10px;">Employer Share on ESI:</p>
                    <!-- <img src="./public/infosym.png" width="20px" alt="" style="margin-left: 240px; margin-top: -20px;"> -->
                    <div style="display: flex; margin-top: 10px;">
                        <div style="display: flex; margin-top: 10px;">
                            <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Employer Share:</label>
                            <div style="display: flex; margin-left: 20px;">
                                <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                <input type="text" value="<?php echo $row['esi2']; ?>"  style="font-size: 18px; width: 300px; height: 40px; border: 1px solid rgb(185,185,185);">
                                <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Basicpay after deductions -->
                <div>
                    <p style="margin-left: 20px; margin-top: 10px;">Basic pay after deductions:</p>
                    <!-- <img src="./public/infosym.png" width="20px" alt="" style="margin-left: 280px; margin-top: -20px;"> -->
                    <div style="display: flex; margin-top: 10px;">
                        <div style="display: flex; margin-top: 10px;">
                            <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Basic Pay:</label>
                            <div style="display: flex; margin-left: 67px;">
                                <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                <input type="text" value="<?php echo $row['abp']; ?>"  style="font-size: 18px; width: 300px; height: 40px; border: 1px solid rgb(185,185,185);">
                                <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                            </div>
                        </div>
                    </div>
                </div> <br>
                <!-- Cross Calc -->
                <hr style="width: 101%;">
                <div>
                    <div style="display: flex; margin-top: 10px;">
                        <div style="display: flex;">
                            <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">CTC Calc:</label>
                            <div style="display: flex; margin-left: 10px;">
                                <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                <input type="text" value="<?php echo $row['ctc']; ?>"  style="font-size: 18px; width: 150px; height: 40px; border: 1px solid rgb(185,185,185);">
                                <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                            </div>
                        </div>
                        <div style="display: flex;">
                            <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Total Deductions:</label>
                            <div style="display: flex; margin-left: 10px;">
                                <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                <input type="text" value="<?php echo $row['tde']; ?>" style="font-size: 18px; width: 120px; height: 40px; border: 1px solid rgb(185,185,185);">
                                <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                            </div>
                        </div>
                    </div>
                    <div style="display: flex; margin-top: 10px;">
                        <div style="display: flex;">
                            <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">NET Pay:</label>
                            <div style="display: flex; margin-left: 15px;">
                                <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                <input type="text" value="<?php echo $row['netpay']; ?>" style="font-size: 18px; width: 150px; height: 40px; border: 1px solid rgb(185,185,185);">
                                <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                            </div>
                        </div>
                        <div style="display: flex;">
                            <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Employer Share:</label>
                            <div style="display: flex; margin-left: 18px;">
                                <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                <input type="text" value="<?php echo $row['tes']; ?>"  style="font-size: 18px; width: 120px; height: 40px; border: 1px solid rgb(185,185,185);">
                                <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                            </div>
                        </div>
                    </div>
                    <!-- <p style="margin-left: 20px; font-weight: lighter; font-size: 15px; margin-top: 10px; color: #F46114;">Total Employer share on EPF is 12%</p> -->
                </div>
                <div style="margin-top: 20px; border-top: 1px solid rgb(209, 209, 209);">
                    <button type="button" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2" style="position: absolute; right: 20px; margin-top: 10px;" onclick="showSection(2)">Next</button>
                </div>
            </div>
        </div>
        <!-- Annual Component -->
        <div class="section" id="section2" style="scale: 0.9; margin-left: -50px; margin-top: -87px;">
            <div style="position: absolute; top: -15px;">
                <p style="text-align: center; font-size: 25px; padding-top: 20px;">Annual Component</p>
                <!-- <hr/> -->
                <!-- Salary Details -->
                <div>
                    <p style="margin-left: 20px; margin-top: 10px;">Salary Details:</p>
                    <!-- <img src="./public/infosym.png" width="20px" alt="" style="margin-left: 160px; margin-top: -20px;"> -->
                    <div style="display: flex; margin-top: 10px;">
                        <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Gross Salary (CTC):</label>
                        <div style="display: flex; margin-left: 20px;">
                            <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                            <input type="text" value="<?php echo $row['actc']; ?>" style="font-size: 18px; width: 300px; height: 40px; border: 1px solid rgb(185,185,185);">
                            <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                        </div>
                    </div>
                    <div style="display: flex; margin-top: 10px;">
                        <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Basic Pay:</label>
                        <div style="display: flex; margin-left: 86px;">
                            <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                            <input type="text" value="<?php echo $row['aabp']; ?>" style="font-size: 18px; width: 300px; height: 40px; border: 1px solid rgb(185,185,185);">
                            <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                        </div>
                    </div>
                    <div style="display: flex; margin-top: 10px;">
                        <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">HRA:</label>
                        <div style="display: flex; margin-left: 130px;">
                            <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                            <input type="text" value="<?php echo $row['ahra']; ?>" style="font-size: 18px; width: 300px; height: 40px; border: 1px solid rgb(185,185,185);">
                            <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                        </div>
                    </div>
                    <div style="display: flex; margin-top: 10px;">
                        <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Other Allowances:</label>
                        <div style="display: flex; margin-left: 25px;">
                            <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                            <input type="text" value="<?php echo $row['aoa']; ?>" style="font-size: 18px; width: 300px; height: 40px; border: 1px solid rgb(185,185,185);">
                            <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                        </div>
                    </div>

                </div>
                <!-- Deductions on Basic pay -->
                <div>
                    <p style="margin-left: 20px; margin-top: 10px;">Deductions on Basic pay:</p>
                    <!-- <img src="./public/infosym.png" width="20px" alt="" style="margin-left: 260px; margin-top: -20px;"> -->
                    <div style="display: flex; margin-top: 10px;">
                        <div style="display: flex;">
                            <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">EPF:</label>
                            <div style="display: flex; margin-left: 40px;">
                                <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                <input type="text" value="<?php echo $row['aepf1']; ?>" style="font-size: 18px; width: 150px; height: 40px; border: 1px solid rgb(185,185,185);">
                                <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                            </div>
                        </div>
                        <div style="display: flex;">
                            <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">ESI:</label>
                            <div style="display: flex; margin-left: 70px;">
                                <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                <input type="text" value="<?php echo $row['aesi1']; ?>" style="font-size: 18px; width: 150px; height: 40px; border: 1px solid rgb(185,185,185);">
                                <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                            </div>
                        </div>
                    </div>
                    <!-- <p style="margin-left: 20px; font-weight: lighter; font-size: 15px; margin-top: 10px; color: #F46114;">ESI deductions applicable only if gross salary is more than 21000</p> -->
                </div>
                <!-- Employer share EPF -->
                <div>
                    <p style="margin-left: 20px; margin-top: 10px;">Employer Share on EPF:</p>
                    <!-- <img src="./public/infosym.png" width="20px" alt="" style="margin-left: 250px; margin-top: -20px;"> -->
                    <div style="display: flex; margin-top: 10px;">
                        <div style="display: flex;">
                            <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Pension:</label>
                            <div style="display: flex; margin-left: 10px;">
                                <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                <input type="text" value="<?php echo $row['aepf2']; ?>" style="font-size: 18px; width: 150px; height: 40px; border: 1px solid rgb(185,185,185);">
                                <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                            </div>
                        </div>
                        <div style="display: flex;">
                            <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">EPF Share:</label>
                            <div style="display: flex; margin-left: 10px;">
                                <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                <input type="text" value="<?php echo $row['aepf3']; ?>" style="font-size: 18px; width: 150px; height: 40px; border: 1px solid rgb(185,185,185);">
                                <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                            </div>
                        </div>
                    </div>
                    <!-- <p style="margin-left: 20px; font-weight: lighter; font-size: 15px; margin-top: 10px; color: #F46114;">Total Employer share on EPF is 12%</p> -->
                </div>
                <!-- Employer share ESI -->
                <div>
                    <p style="margin-left: 20px; margin-top: 10px;">Employer Share on ESI:</p>
                    <!-- <img src="./public/infosym.png" width="20px" alt="" style="margin-left: 240px; margin-top: -20px;"> -->
                    <div style="display: flex; margin-top: 10px;">
                        <div style="display: flex; margin-top: 10px;">
                            <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Employer Share:</label>
                            <div style="display: flex; margin-left: 20px;">
                                <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                <input type="text" value="<?php echo $row['aesi2']; ?>" style="font-size: 18px; width: 300px; height: 40px; border: 1px solid rgb(185,185,185);">
                                <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Basicpay after deductions -->
                <div>
                    <p style="margin-left: 20px; margin-top: 10px;">Basic pay after deductions:</p>
                    <!-- <img src="./public/infosym.png" width="20px" alt="" style="margin-left: 280px; margin-top: -20px;"> -->
                    <div style="display: flex; margin-top: 10px;">
                        <div style="display: flex; margin-top: 10px;">
                            <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Basic Pay:</label>
                            <div style="display: flex; margin-left: 67px;">
                                <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                <input type="text" value="<?php echo $row['aabp']; ?>" style="font-size: 18px; width: 300px; height: 40px; border: 1px solid rgb(185,185,185);">
                                <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                            </div>
                        </div>
                    </div>
                </div> <br>
                <!-- Cross Calc -->
                <hr style="width: 101%;">
                <div>
                    <div style="display: flex; margin-top: 10px;">
                        <div style="display: flex;">
                            <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">CTC Calc:</label>
                            <div style="display: flex; margin-left: 10px;">
                                <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                <input type="text" value="<?php echo $row['actc']; ?>" style="font-size: 18px; width: 150px; height: 40px; border: 1px solid rgb(185,185,185);">
                                <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                            </div>
                        </div>
                        <div style="display: flex;">
                            <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Total Deductions:</label>
                            <div style="display: flex; margin-left: 10px;">
                                <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                <input type="text" value="<?php echo $row['atde']; ?>" style="font-size: 18px; width: 120px; height: 40px; border: 1px solid rgb(185,185,185);">
                                <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                            </div>
                        </div>
                    </div>
                    <div style="display: flex; margin-top: 10px;">
                        <div style="display: flex;">
                            <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">NET Pay:</label>
                            <div style="display: flex; margin-left: 15px;">
                                <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                <input type="text" value="<?php echo $row['anetpay']; ?>" style="font-size: 18px; width: 150px; height: 40px; border: 1px solid rgb(185,185,185);">
                                <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                            </div>
                        </div>
                        <div style="display: flex;">
                            <label for="" style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Employer Share:</label>
                            <div style="display: flex; margin-left: 18px;">
                                <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                                <input type="text" value="<?php echo $row['ates']; ?>" style="font-size: 18px; width: 120px; height: 40px; border: 1px solid rgb(185,185,185);">
                                <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                            </div>
                        </div>
                    </div>
                    <!-- <p style="margin-left: 20px; font-weight: lighter; font-size: 15px; margin-top: 10px; color: #F46114;">Total Employer share on EPF is 12%</p> -->
                </div>
                <div style="margin-top: 20px; border-top: 1px solid rgb(209, 209, 209);">
                    <button type="button" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2" style="position: absolute; right: 100px; margin-top: 10px;" onclick="showSection(1)">Prev</button>
                    <button class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2" style="position: absolute; right: 20px; margin-top: 10px;">Link</button>
                </div>
            </div>
        </div>
        <?php
        }
    } else {
        echo "No data found";
    }
} else {
    echo "Invalid request";
}
?>

