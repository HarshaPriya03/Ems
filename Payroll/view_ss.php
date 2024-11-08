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


$sql = "
SELECT id,empname,fgs,fhra,foa,fbp,monthdays,present,leaves,sundays,flop,paydays,gross,hra,oa,bp,epf1,esi1,tds,emi,lopamt,misc,totaldeduct,bonus,payout FROM payroll_ss_vsp WHERE empname = ?
UNION ALL
SELECT id,empname,fgs,fhra,foa,fbp,monthdays,present,leaves,sundays,flop,paydays,gross,hra,oa,bp,epf1,esi1,tds,emi,lopamt,misc,totaldeduct,bonus,payout FROM payroll_ss_ggm WHERE empname = ?
UNION ALL
SELECT id,empname,fgs,fhra,foa,fbp,monthdays,present,leaves,sundays,flop,paydays,gross,hra,oa,bp,epf1,esi1,tds,emi,lopamt,misc,totaldeduct,bonus,payout FROM payroll_ss_sp WHERE empname = ?
LIMIT 1
";


    $query = $con->prepare($sql);
    $query->bind_param('s', $eid);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

?>

            <div class="p-4 md:p-1 space-y-2">
         <p style="display:flex; justify-content:center; color: #333333; margin-top:-30px; font-size:22px;" id="empName"><span style="color:#777777">EMP NAME :</span> <?php echo $row['empname']; ?></p><hr />
                    <p style="display:flex; margin-left:20px; margin-top:0px;">Fixed Salary Components:</p>
                   <div style="display: flex;">
                    <div style="display: flex;">
                      <label  style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Gross Salary (CTC):</label>
                      <div style="display: flex; margin-left: 16px;">
                          <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                          <input name="ags" id="fgs" type="text" value="<?php echo $row['fgs']; ?>" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                          <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                      </div>
                  </div>
                  <div style="display: flex;">
                    <label  style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">HRA:</label>
                    <div style="display: flex; margin-left: 40px;">
                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                        <input name="ags" id="fhra" type="text" value="<?php echo $row['fhra']; ?>" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                    </div>
                </div>
                   </div>
                   <div style="display: flex;">
                    <div style="display: flex;">
                      <label  style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">OA:</label>
                      <div style="display: flex; margin-left: 140px;">
                          <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                          <input name="ags" id="foa" type="text" value="<?php echo $row['foa']; ?>" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);"  readonly />
                          <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                      </div>
                  </div>
                  <div style="display: flex;">
                    <label  style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Basic Pay:</label>
                    <div style="display: flex; margin-left: 0px;">
                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                        <input name="ags" id="fbp" type="text" value="<?php echo $row['fbp']; ?>" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);"  readonly />
                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                    </div>
                </div>
                   </div>
                   <p style="display:flex; margin-left:20px;">Days Calculation:</p>
                   <div style="display: flex;">
                    <div style="display: flex;">
                      <label  style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Total Days:</label>
                      <div style="display: flex; margin-left: 30px;">
                          <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;"><img src="./public/calendar3d.png" width="25px" /></div>
                          <input name="ags" id="monthdays" type="text" value="<?php echo $row['monthdays']; ?>" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);"  readonly />
                          <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                      </div>
                  </div>
                  <div style="display: flex;">
                    <label  style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Present Days:</label>
                    <div style="display: flex; margin-left: 25px;">
                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;"><img src="./public/calendar3d.png" width="25px" /></div>
                        <input name="ags" id="present" type="text" value="<?php echo $row['present']; ?>" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);"  readonly />
                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                    </div>
                </div>
                   </div>
                   <div style="display: flex;">
                    <div style="display: flex;">
                      <label  style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Leaves:</label>
                      <div style="display: flex; margin-left: 55px;">
                          <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;"><img src="./public/calendar3d.png" width="25px" /></div>
                          <input name="ags" id="leaves" type="text" value="<?php echo $row['leaves']; ?>" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                          <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                      </div>
                  </div>
                  <div style="display: flex;">
                    <label  style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Week Off's:</label>
                    <div style="display: flex; margin-left: 50px;">
                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;"><img src="./public/calendar3d.png" width="25px" /></div>
                        <input name="ags" id="sundays" type="text" value="<?php echo $row['sundays']; ?>" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);"  readonly />
                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                    </div>
                </div>
                   </div>
                   <div style="display: flex;">
                    <div style="display: flex;">
                      <label  style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">LOP:</label>
                      <div style="display: flex; margin-left: 80px;">
                          <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;"><img src="./public/calendar3d.png" width="25px" /></div>
                          <input name="ags" id="flop" type="text" value="<?php echo $row['flop']; ?>" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);"  readonly />
                          <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                      </div>
                  </div>
                  <div style="display: flex;">
                    <label  style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Pay Day's:</label>
                    <div style="display: flex; margin-left: 53px;">
                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;"><img src="./public/calendar3d.png" width="25px" /></div>
                        <input name="ags" id="paydays" type="text" value="<?php echo $row['paydays']; ?>" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                    </div>
                </div>
                   </div>
                       <p style="display:flex; margin-left:20px;">Salary as per number of days:</p>
                   <div style="display: flex;">
                    <div style="display: flex;">
                      <label  style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Gross Salary (CTC):</label>
                      <div style="display: flex; margin-left: 16px;">
                          <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                          <input name="ags" id="gross" type="text" value="<?php echo $row['gross']; ?>" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);"  readonly />
                          <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                      </div>
                  </div>
                  <div style="display: flex;">
                    <label  style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">HRA:</label>
                    <div style="display: flex; margin-left: 40px;">
                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                        <input name="ags" id="empHRA" type="text" value="<?php echo $row['hra']; ?>" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                    </div>
                </div>
                   </div>
                   <div style="display: flex;">
                    <div style="display: flex;">
                      <label  style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">OA:</label>
                      <div style="display: flex; margin-left: 140px;">
                          <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                          <input name="ags" id="oa" type="text" value="<?php echo $row['oa']; ?>" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);"  readonly />
                          <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                      </div>
                  </div>
                  <div style="display: flex;">
                    <label  style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Basic Pay:</label>
                    <div style="display: flex; margin-left: 0px;">
                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                        <input name="ags" id="bp" type="text" value="<?php echo $row['bp']; ?>" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);"  readonly />
                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                    </div>
                </div>
                   </div>
                   <p style="display:flex; margin-left:20px;">Deductions:</p>
                   <div style="display: flex;">
                    <div style="display: flex;">
                      <label  style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">EPF:</label>
                      <div style="display: flex; margin-left: 130px;">
                          <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                          <input name="ags" id="epf1" type="text" value="<?php echo $row['epf1']; ?>" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                          <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                      </div>
                  </div>
                  <div style="display: flex;">
                    <label  style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">ESIC:</label>
                    <div style="display: flex; margin-left: 42px;">
                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                        <input name="ags" id="esi1" type="text" value="<?php echo $row['esi1']; ?>" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);"  readonly />
                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                    </div>
                </div>
                   </div>
                        <div style="display: flex;">
                    <div style="display: flex;">
                      <label  style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">TDS:</label>
                      <div style="display: flex; margin-left: 130px;">
                          <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                          <input name="ags" id="tds" type="text" value="<?php echo $row['tds']; ?>" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                          <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                      </div>
                  </div>
                  <div style="display: flex;">
                    <label  style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Loan EMI:</label>
                    <div style="display: flex; margin-left: 5px;">
                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                        <input name="ags" id="emi" type="text" value="<?php echo $row['emi']; ?>" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);"  readonly />
                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                    </div>
                </div>
                   </div>
                   <div style="display: flex;">
                    <div style="display: flex;">
                      <label  style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">LOP:</label>
                      <div style="display: flex; margin-left: 130px;">
                          <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                          <input name="ags" id="lopamt" type="text" value="<?php echo $row['lopamt']; ?>" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);" readonly />
                          <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                      </div>
                  </div>
                  
                  <div style="display: flex;">
                    <label  style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Total Ded.:</label>
                    <div style="display: flex; margin-left: px;">
                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                        <input name="ags" id="totaldeduct" type="text" value="<?php echo $row['totaldeduct']; ?>" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);"  readonly />
                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                    </div>
                </div>
                   </div><hr/>
                   <div style="display: flex; justify-content:center;">
                    <label  style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Net Payout:</label>
                    <div style="display: flex; margin-left:10px;">
                        <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                        <input name="ags" id="payout" type="text" value="<?php echo $row['payout']; ?>" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);"  readonly />
                        <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                    </div>
                </div>
            </div>

<?php
        }
    } else {
        echo "No data found";
    }
} else {
    echo "No data received";
}
?>