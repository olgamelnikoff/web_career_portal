
        function addFieldsCredit(){
            
            // Container <div> where dynamic content will be placed
            var container = document.getElementById("container");
            // Clear previous contents of the container
             while (container.hasChildNodes()) {
                 container.removeChild(container.lastChild);
             }
                var L = document.createElement("label");
                L.setAttribute("for", "FullName");
                L.textContent = "Name on Card: ";
                container.appendChild(L);
                var NC = document.createElement("input"); 
                NC.setAttribute("type", "text"); 
                NC.setAttribute("name", "FullName"); 
                NC.setAttribute("placeholder", "Name on card"); 
                NC.required = true;
                container.appendChild(NC);
                container.appendChild(document.createElement("br"));

                var C = document.createElement("label");
                C.setAttribute("for", "ccnumber");
                C.textContent = "Card Number: ";
                container.appendChild(C);
                var CC = document.createElement("input"); 
                CC.setAttribute("type", "text"); 
                CC.setAttribute("name", "ccnumber"); 
                CC.setAttribute("placeholder", "credit card number"); 
                CC.required = true;
                container.appendChild(CC);
                container.appendChild(document.createElement("br"));

                var V = document.createElement("label");
                V.setAttribute("for", "CVC");
                V.textContent = "CVC: ";
                container.appendChild(V);
                var CVC = document.createElement("input"); 
                CVC.setAttribute("type", "number"); 
                CVC.setAttribute("max", "999"); 
                CVC.setAttribute("name", "CVC"); 
                CVC.setAttribute("placeholder", "CVC"); 
                CVC.required = true;
                container.appendChild(CVC);
                container.appendChild(document.createElement("br"));
                var E = document.createElement("label");
                E.setAttribute("for", "expiration");
                E.textContent = "expiration Date: ";
                container.appendChild(E);
                var EM = document.createElement("select"); 
                EM.setAttribute("name", "expM" );
                EM.appendChild(new Option("01", "01"));
                EM.appendChild(new Option("02", "02"));
                EM.appendChild(new Option("03", "03"));
                EM.appendChild(new Option("04", "04"));
                EM.appendChild(new Option("05", "05"));
                EM.appendChild(new Option("06", "06"));
                EM.appendChild(new Option("07", "07"));
                EM.appendChild(new Option("08", "08"));
                EM.appendChild(new Option("09", "09"));
                EM.appendChild(new Option("10", "10"));
                EM.appendChild(new Option("11", "11"));
                EM.appendChild(new Option("12", "12"));
                container.appendChild(EM);
                var EY = document.createElement("select"); 
                EY.setAttribute("name", "expY" );
                EY.appendChild(new Option("2020", "2020"));
                EY.appendChild(new Option("2021", "2021"));
                EY.appendChild(new Option("2022", "2022"));
                EY.appendChild(new Option("2023", "2023"));
                EY.appendChild(new Option("2024", "2024"));
                EY.appendChild(new Option("2025", "2025"));
                EY.appendChild(new Option("2026", "2026"));
                EY.appendChild(new Option("2027", "2027"));
                EY.appendChild(new Option("2028", "2028"));
                EY.appendChild(new Option("2029", "2029"));
                EY.appendChild(new Option("2030", "2030"));
                container.appendChild(EY);
                container.appendChild(document.createElement("br"));
                //    // Create an input element for withdrawl type
                var W = document.createElement("label");
                W.setAttribute("for", "withdrawl");
                W.textContent = "Withdrawal Type: ";
                container.appendChild(W);
                var WI = document.createElement("select");
                WI.setAttribute("name", "wcredit");
                WI.appendChild(new Option("automatic", "automatic"));
                WI.appendChild(new Option("manual", "manual"));
                container.appendChild(WI);
                container.appendChild(document.createElement("br"));
                // Create an input element for priority
                var P = document.createElement("label");
                P.setAttribute("for", "withdrawl");
                P.textContent = "Priority: ";
                container.appendChild(P);
                var PI = document.createElement("select");
                PI.setAttribute("name", "pcredit");
                PI.appendChild(new Option("primary", "primary"));
                PI.appendChild(new Option("secondary", "secondary"));
                container.appendChild(PI);
                container.appendChild(document.createElement("br"));
                            
        }



        function addFieldsChecking(){
            
            // Container <div> where dynamic content will be placed
            var container = document.getElementById("container2");
            // Clear previous contents of the container
             while (container.hasChildNodes()) {
                 container.removeChild(container.lastChild);
             }
                var L = document.createElement("label");
                L.setAttribute("for", "Accountnumber");
                L.textContent = "Account Number: ";
                container.appendChild(L);
                var NC = document.createElement("input"); 
                NC.setAttribute("type", "number"); 
                NC.setAttribute("max", "9999999999"); 
                NC.setAttribute("name", "accountnumber"); 
                NC.setAttribute("placeholder", "0000000"); 
                NC.required = true;
                container.appendChild(NC);
                container.appendChild(document.createElement("br"));

                var C = document.createElement("label");
                C.setAttribute("for", "transitnum");
                C.textContent = "Transit Number: ";
                container.appendChild(C);
                var CC = document.createElement("input"); 
                CC.setAttribute("type", "number"); 
                CC.setAttribute("max", "99999"); 
                CC.setAttribute("name", "transitnum"); 
                CC.setAttribute("placeholder", "00000"); 
                CC.required = true;
                container.appendChild(CC);
                container.appendChild(document.createElement("br"));

                var V = document.createElement("label");
                V.setAttribute("for", "institutionnum");
                V.textContent = "Institution number: ";
                container.appendChild(V);
                var CVC = document.createElement("input"); 
                CVC.setAttribute("type", "number"); 
                CVC.setAttribute("max", "999"); 
                CVC.setAttribute("name", "institutionnum"); 
                CVC.setAttribute("placeholder", "000"); 
                CVC.required = true;
                container.appendChild(CVC);
                container.appendChild(document.createElement("br"));
                //    // Create an input element for withdrawl type
                var W = document.createElement("label");
                W.setAttribute("for", "withdrawl");
                W.textContent = "Withdrawal Type: ";
                container.appendChild(W);
                var WI = document.createElement("select");
                WI.setAttribute("name", "wchecking");
                WI.appendChild(new Option("automatic", "automatic"));
                WI.appendChild(new Option("manual", "manual"));
                container.appendChild(WI);
                container.appendChild(document.createElement("br"));
                // Create an input element for priority
                var P = document.createElement("label");
                P.setAttribute("for", "withdrawl");
                P.textContent = "Priority: ";
                container.appendChild(P);
                var PI = document.createElement("select");
                PI.setAttribute("name", "pchecking");
                PI.appendChild(new Option("primary", "primary"));
                PI.appendChild(new Option("secondary", "secondary"));
                container.appendChild(PI);
                container.appendChild(document.createElement("br"));                 
        }
