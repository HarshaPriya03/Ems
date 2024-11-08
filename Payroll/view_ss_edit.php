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

    $sql = "SELECT * FROM payroll_ss
    WHERE empname = ?";


    $query = $con->prepare($sql);
    $query->bind_param('s', $eid);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
?>
            <form id="editSS">
            <div class=" space-y-2">
            <input style="margin-left:220px;color: #666666;" id="empname" value="<?php echo $row['empname']; ?>">
            <hr />
            <p style="display:flex; margin-left:20px; margin-top:0px;">Fixed Salary Components:</p>
            <div style="display: flex; margin-top: -10px;">
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Gross Salary:</label>
                <div style="display: flex; margin-left: 16px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="fgs" id="fgs" value="<?php echo $row['fgs']; ?>" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);"  />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">HRA:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="fhra" id="fhra" value="<?php echo $row['fhra']; ?>" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);"  />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">OA:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="foa" id="foa" value="<?php echo $row['foa']; ?>" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);"  />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Basic Pay:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="fbp" id="fbp" value="<?php echo $row['fbp']; ?>" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);"  />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
            </div>
            <p style="display:flex; margin-left:20px;">Days Calculation:</p>
            <div style="display: flex; margin-top: -10px;">
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Total Days:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;"><img src="./public/calendar3d.png" width="25px" /></div>
                  <input name="monthdays" id="monthdays" value="<?php echo $row['monthdays']; ?>" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);"  />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Present Days:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;"><img src="./public/calendar3d.png" width="25px" /></div>
                  <input name="present" id="present" value="<?php echo $row['present']; ?>" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);"  />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Leaves:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;"><img src="./public/calendar3d.png" width="25px" /></div>
                  <input name="leaves" id="leaves" value="<?php echo $row['leaves']; ?>" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);"  />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Week Off's:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;"><img src="./public/calendar3d.png" width="25px" /></div>
                  <input name="sundays" id="sundays" value="<?php echo $row['sundays']; ?>" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);"  />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
            </div>
            <div style="display: flex; margin-top: -10px;">
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">LOP:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;"><img src="./public/calendar3d.png" width="25px" /></div>
                  <input name="flop" id="flop" value="<?php echo $row['flop']; ?>" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);"  />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Pay Day's:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;"><img src="./public/calendar3d.png" width="25px" /></div>
                  <input name="paydays" id="paydays" value="<?php echo $row['paydays']; ?>" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);"  />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
            </div>
            <p style="display:flex; margin-left:20px;">Salary as per number of days:</p>
            <div style="display: flex; margin-top: -10px;">
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Gross Salary (CTC):</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="gross" id="gross" value="<?php echo $row['gross']; ?>" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);"  />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">HRA:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="hra" id="hra" value="<?php echo $row['hra']; ?>"  type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);"  />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">OA:</label>
                <div style="display: flex; margin-left:20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="oa" id="oa" value="<?php echo $row['oa']; ?>"  type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);"  />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Basic Pay:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="bp" id="bp" value="<?php echo $row['bp']; ?>"  type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);"  />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
            </div>
            <p style="display:flex; margin-left:20px;">Deductions:</p>
            <div style="display: flex; margin-top: -10px;">
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">EPF:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="epf1" id="epf1" value="<?php echo $row['epf1']; ?>"  type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);"  />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">ESIC:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="esi1" id="esi1" value="<?php echo $row['esi1']; ?>"  type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);"  />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">TDS:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="tds" id="tds" value="<?php echo $row['tds']; ?>"  type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);"  />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Loan EMI:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="emi" id="emi" value="<?php echo $row['emi']; ?>"  type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);"  />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
            </div>
            <div style="display: flex; margin-top: -10px;">
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">LOP:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="lopamt" id="lopamt" value="<?php echo $row['lopamt']; ?>"  type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);"  />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>

              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Misc. Deductions:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="misc" id="misc" value="<?php echo $row['misc']; ?>" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);"  />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Total Deductions:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="totaldeduct" id="totaldeduct" value="<?php echo $row['totaldeduct']; ?>" type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);"  />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
            </div>
            <p style="display:flex; margin-left:20px;">Additional Compensation:</p>
            <div style="display: flex; margin-top: -10px;">
              <div>
                <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Bonus:</label>
                <div style="display: flex; margin-left: 20px;">
                  <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                  <input name="bonus" id="bonus" value="<?php echo $row['bonus']; ?>"  type="text" style="font-size: 18px; width: 90px; height: 40px; border: 1px solid rgb(185,185,185);"  />
                  <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
                </div>
              </div>
            </div>
            <hr />
            <div style="display: flex; justify-content:center;">
              <label style="font-weight: lighter; margin-top: 10px; font-size: 18px; margin-left: 20px;">Net Payout:</label>
              <div style="display: flex; margin-left:10px;">
                <div style="display: flex; border: 1px solid rgb(185,185,185); width: 30px; align-items: center; justify-content: center; background-color: rgb(240, 240, 240); border-top-left-radius: 10px; border-bottom-left-radius: 10px;">₹</div>
                <input name="payout" id="payout" value="<?php echo $row['payout']; ?>"  type="text" style="font-size: 18px; width: 110px; height: 40px; border: 1px solid rgb(185,185,185);"  />
                <div style="display: flex; width: 30px; align-items: center; border: 1px solid rgb(185,185,185); justify-content: center; background-color: rgb(240, 240, 240); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">/-</div>
              </div>
            </div>
             <input type="hidden" name="status1" value="0">
                    <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button type="submit" id="updateSS" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Update
                        </button>
                        <button data-modal-hide="default-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Cancel</button>
                    </div>

                </div>
            </form>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

            <script>
$(document).ready(function(){
    $('#editSS').on('submit', function(e){
        e.preventDefault(); // Prevent form submission
        
        // Get form data
        var formData = $(this).serialize();

        // Add empname to formData
        formData += '&empname=' + encodeURIComponent($('#empname').val());

        // Send AJAX request
        $.ajax({
            url: 'update_payroll.php',
            type: 'POST',
            data: formData,
            success: function(response){
                // Parse JSON response
                var data = JSON.parse(response);
                
                // Check if update was successful
                if(data.success) {
                    // Show success message using SweetAlert2
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Payroll updated successfully'
                    }).then(function() {
                        // Reload the page after success
                        location.reload();
                    });
                } else {
                    // Show error message using SweetAlert2
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to update payroll'
                    });
                }
            },
            error: function(xhr, status, error){
                // Show error message using SweetAlert2
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while processing your request'
                });
                console.error(xhr.responseText);
            }
        });
    });
});
</script>

<?php
        }
    } else {
        echo "No data found";
    }
} else {
    echo "No data received";
}
?>