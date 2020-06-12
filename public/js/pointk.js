var x = $("#command")[0].childNodes;
      var y = [];
      for (var i = 0; i < x.length; i++) {
        y.push(x[i].cloneNode(true));
      }
      const z = y;
      $(".moins").click(function(e) {
        var targ = e.target.parentNode.nextElementSibling;
        if (targ.value > 0) targ.value--;
        var formHe = $("#formHe")[0];
        var table = formHe.lastElementChild.childNodes;
        var tableEl = [];
        for (var i = 0; i < table.length; i++) {
          if (table[i].nodeName == 'DIV') tableEl.push(table[i]);
        }
        var tot = 0;
        for (var i = 0; i < tableEl.length - 1; i++) {
          var a = tableEl[i].firstElementChild.firstElementChild;
          a = a.lastElementChild.value;
          var b = tableEl[i].lastElementChild.firstElementChild;
          b = b.firstElementChild.nextElementSibling.value;
          tot += a * b;
        }
        var c = tableEl[tableEl.length - 1].lastElementChild;
        c.value = tot;
        e.preventDefault();
      });

      $(".plus").click(function(e) {
        var targ = e.target.parentNode.previousElementSibling;
        targ.value++;
        var formHe = $("#formHe")[0];
        var table = formHe.lastElementChild.childNodes;
        var tableEl = [];
        for (var i = 0; i < table.length; i++) {
          if (table[i].nodeName == 'DIV') tableEl.push(table[i]);
        }
        var tot = 0;
        for (var i = 0; i < tableEl.length - 1; i++) {
          var a = tableEl[i].firstElementChild.firstElementChild;
          a = a.lastElementChild.value;
          var b = tableEl[i].lastElementChild.firstElementChild;
          b = b.firstElementChild.nextElementSibling.value;
          tot += a * b;
        }
        var c = tableEl[tableEl.length - 1].lastElementChild;
        c.value = tot;
        e.preventDefault();
      });

      $("#mod").click(function() {
        var a, v;
        if ($("#name")[0].nodeName == 'DIV') {
          a = document.createElement('input');
          v = $("#name")[0].innerHTML;
          a.id = 'name';
          a.value = v;
          a.setAttribute('class', "form-control col-sm-6");
        } else {
          a = document.createElement('div');
          v = $("#name")[0].value;
          a.id = "name";
          a.innerHTML = v;
        }
        $("#tab")[0].removeChild($("#name")[0]);
        $("#tab")[0].appendChild(a);
      });

      $(".modify").click(function(e) {
        var targ = e.target.parentNode.previousElementSibling;
        var a = $("#formHe")[0].cloneNode(true);
        a.setAttribute('class', '')
        a.id = "formCom";
        a.firstElementChild.innerHTML = targ.value;
        var chil = a.lastElementChild.childNodes;
        var chilDiv = [];

        for (var i = 0; i < chil.length; i++)
          if (chil[i].nodeName == 'DIV') chilDiv.push(chil[i]);
        chilDiv.pop();

        var cha = {
          "Commande 1": [3, 1],
          "Commande 2": [2, 2],
        };
        
        for (var i = chilDiv.length - 1; i >= 0; i--) {
          var val = chilDiv[i].lastElementChild;
          val = val.firstElementChild;
          val.setAttribute('class', 'input-group inCom');
          val = val.firstElementChild.nextElementSibling;

          val.value = cha[targ.value][i];
        }

        var com = $("#command")[0];
        while (com.childNodes.length > 0)
          com.removeChild(com.firstChild);

        com.appendChild(a);

        var tot = 0;
        var formCom = $("#formCom")[0];
        var table = formCom.lastElementChild.childNodes;
        var tableEl = [];
        for (var i = 0; i < table.length; i++) {
          if (table[i].nodeName == 'DIV') tableEl.push(table[i]);
        }
        var tot = 0;
        for (var i = 0; i < tableEl.length - 1; i++) {
          var a = tableEl[i].firstElementChild.firstElementChild;
          a = a.lastElementChild.value;
          var b = tableEl[i].lastElementChild.firstElementChild;
          b = b.firstElementChild.nextElementSibling.value;
          tot += a * b;
        }
        var c = tableEl[tableEl.length - 1].lastElementChild;
        c.value = tot;
        var i = table[table.length - 2].firstElementChild;
        i.value = "Modifier";

        $(".inCom div .moins").click(function(e) {
          var targ = e.target.parentNode.nextElementSibling;
          if (targ.value > 0) targ.value--;
          var formCom = $("#formCom")[0];
          var table = formCom.lastElementChild.childNodes;
          var tableEl = [];
          for (var i = 0; i < table.length; i++) {
            if (table[i].nodeName == 'DIV') tableEl.push(table[i]);
          }
          var tot = 0;
          for (var i = 0; i < tableEl.length - 1; i++) {
            var a = tableEl[i].firstElementChild.firstElementChild;
            a = a.lastElementChild.value;
            var b = tableEl[i].lastElementChild.firstElementChild;
            b = b.firstElementChild.nextElementSibling.value;
            tot += a * b;
          }
          var c = tableEl[tableEl.length - 1].lastElementChild;
          c.value = tot;
          e.preventDefault();
        });

        $(".inCom div .plus").click(function(e) {
          var targ = e.target.parentNode.previousElementSibling;
          targ.value++;
          var formCom = $("#formCom")[0];
          var table = formCom.lastElementChild.childNodes;
          var tableEl = [];
          for (var i = 0; i < table.length; i++) {
            if (table[i].nodeName == 'DIV') tableEl.push(table[i]);
          }
          var tot = 0;
          for (var i = 0; i < tableEl.length - 1; i++) {
            var a = tableEl[i].firstElementChild.firstElementChild;
            a = a.lastElementChild.value;
            var b = tableEl[i].lastElementChild.firstElementChild;
            b = b.firstElementChild.nextElementSibling.value;
            tot += a * b;
          }
          var c = tableEl[tableEl.length - 1].lastElementChild;
          c.value = tot;
          e.preventDefault();
        });

        e.preventDefault();
      });

      $(".affich").click(function(e) {
        var targ = e.target.parentNode.previousElementSibling;
        var a = $("#formHe")[0].cloneNode(true);
        a.setAttribute('class', '')
        a.id = "formCom"
        a.firstElementChild.innerHTML = targ.value;
        var chil = a.lastElementChild.childNodes;
        var chilDiv = [];

        for (var i = 0; i < chil.length; i++)
          if (chil[i].nodeName == 'DIV') chilDiv.push(chil[i]);
        chilDiv.pop();

        var cha = {
          "Commande 3": [1, 3],
          "Commande 4": [2, 0],
        };
        
        for (var i = chilDiv.length - 1; i >= 0; i--) {
          var val = chilDiv[i].lastElementChild;
          val = val.firstElementChild;
          val.setAttribute('class', 'input-group inCom');
          val = val.firstElementChild.nextElementSibling;

          val.value = cha[targ.value][i];
        }

        var com = $("#command")[0];
        while (com.childNodes.length > 0)
          com.removeChild(com.firstChild);

        com.appendChild(a);

        var tot = 0;
        var formCom = $("#formCom")[0];
        var table = formCom.lastElementChild.childNodes;
        var tableEl = [];
        for (var i = 0; i < table.length; i++) {
          if (table[i].nodeName == 'DIV') tableEl.push(table[i]);
        }
        var tot = 0;
        for (var i = 0; i < tableEl.length - 1; i++) {
          var a = tableEl[i].firstElementChild.firstElementChild;
          a = a.lastElementChild.value;
          var b = tableEl[i].lastElementChild.firstElementChild;
          b = b.firstElementChild.nextElementSibling.value;
          tot += a * b;
        }
        var c = tableEl[tableEl.length - 1].lastElementChild;
        c.value = tot;
        var i = table[table.length - 2];
        i.parentNode.removeChild(i);

        for (var i = $(".inCom div .moins").length - 1; i >= 0; i--)
          $(".inCom div .moins")[i].disabled = true;

        for (var i = $(".inCom div .plus").length - 1; i >= 0; i--)
          $(".inCom div .plus")[i].disabled = true;
        
        e.preventDefault();
    });