@extends("layouts.front")
@section("front-end")

   <div class="relative bg-cover bg-center h-64" style="background-image: url('data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBwgHBgkIBwgKCgkLDRYPDQwMDRsUFRAWIB0iIiAdHx8kKDQsJCYxJx8fLT0tMTU3Ojo6Iys/RD84QzQ5OjcBCgoKDQwNGg8PGjclHyU3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3N//AABEIAJQBAAMBEQACEQEDEQH/xAAbAAADAQEBAQEAAAAAAAAAAAADBAUCAQYAB//EADsQAAIBAwMCBAQFAQYGAwAAAAECAwAEEQUSITFBEyJRYQYycYEUI0KRoRVScrHB0fA0NUNikuEHJDP/xAAaAQACAwEBAAAAAAAAAAAAAAACAwABBAUG/8QAMhEAAgIBBAEDAwIFAwUAAAAAAAECAxEEEiExQQUTURQiYTJxI4GRodEVseFCQ1Lw8f/aAAwDAQACEQMRAD8A8FHcyDo1N2JnF96a8hlvJgOtX7cSvfs+T4X0w70PtxDWpt+RqDUJ8jnNT2Ysj1tq8j6X9yOgP71Pp4sD/U7UF/qlyuMg1PpYfAS9VtGLfWLjPINA9JD4GL1iwpxavcEDCmlvRxNEPWJ+RpNWuAPlJ+9Klo4mqHq7fgKmtTjqlJejRrh6pnwHj1x84MdJlokao+oZ8Dcerk/9M/vWWehiaI6lS8DKat/2GsVvp1chilFjcOrqf0mudb6NF9MjqTKVvqzKvy5+tXp3rdItsJZX5Ez0afkNJrBC8KP2rVLW6+xYTiv6/wCRcdEm+ybc6wdxJzXO/wBLsuk52Sy2aY6dREpNYU/2q0w9Hiuw9sUJzauq84JrdX6bBLgv3YIRm10DpGa0x0KB+qivAhL8QkHiP+actEvkp65LwLt8RydlIp8dEvkRL1LHgC/xDIT0NMWiiJfqRj+uuw6GiWkSAfqLYKTV5D3NMjpkLlrpMWk1OVu9NVETLPVzE572Q/rpqrijNPUTYjLMx/XR7YiHZNisjEkneamEXFyErgbup5oGaYSEJEOc5qhqMFfrULKkUoNaUziSgPw7XHNXlCfbkbkRFqJoqUXE3b7S3aryCouTLFs0eBuxVbhipCuYsDgVFICenyGi8IcjFC5jYaZJdDccsY9KHcM9oMZU7EVMlxhgw8ye1LZsriZjuFB7VnmdCqIzHdqO4rLM6VcBhbpfWkNGuMRmzn3ygZ4pFi4HxiWllAGAeKyOOS3E5cTgL1q4R5KUcEq6uRg81phACTJb3hJIBrTGBmmz4SeIOtNUBDkLXERIzmjSFtolzqVzTEhUidNIwPWnRM0wDTEd6amZmmD8dt2Q1XwUlI6Z3NVkLawTzOOpq8guGQMlwfWpkntirz+9TJarAtKx6GqyEoIEzk9TUyHtAueaos4MVCzcUop2TB7eWUoJhj5qrIexI7LcD1o0ZJrLMR3Wx+DVtlwhhj0eogDnH70GRzga/qGe4qNgqvkImokd6EeocBV1TnqKgLiHTUwepqMFRNPqagdqBpj4cGE1RM8mlSia654GY9QU85HNJdZuhagw1RAMZyaU62aY3xLmiTCT8xugrLdHwbqZ7lksG8UdxWf2xmUL3d+gX5qKFYubJE2oJnrWmMDNKYm92CcgVoikZptsz/U40GMc0aRnlkFJq6txirJFZEptRRgfLUyFsRNubvIyFo4szzqYo1wzc0zcK9sx4xq8k2G4WeWUKDx6UE5YQyurcxuRBjGOKUpM1OmKJ12hX5eKdGWTHZWl0KpG0sgUd6JywgYwcnhBmtgink0G/LGuhoSkcKxHpTEZ2jBO6rJgyCA3mOBUILqzetGIeA8crjpmiwA2E8Vz1zRCXFGGd6gSSObnx3qmHwaDyepqsEygimU9zVpAuxIMqv3Jq9oDtQZA4HzGptLVqNhXbqTU2l+6bWFu1U4hxtDJG4HU0DghytY1awnxBmlySRork2z01vI1taqu4gmufKO6WTs1z2QwDN5Ju+fj61Tgi1bLJiadmXIYmhSSGSbaBshZd3er3YAcGYilCTAGib4JGHOGC1GNUuPL0YZq4T4KuoxITWPc2OBROeAI05ZlrZgx54FVvQboYCVVxg0abFTgsYFioHFHkzOODhiZ/lBA9RRJi5IJbfkyhseUfMTVT5RdfEhq4dRgxkFaXE1T6yiVdXIbpWiEcGCySbF4JvDmRs4A4NSSBrntlkfkO5Cw+XHXNJWUzbNprJFmBMh2jNaVwjnyayfIj9hUJk7InrxUBYJIqekY3MZS3NEkJdgZbc1eAHYffhjU2le6dFtjrU2k9014AHSptK9wIkWO1GkA5hPDwKvAG4+xg1TCXIWMDPJocjEmNKFxQNjIpmhtzS5SNVcWx6xRS4rNZPg6enpbY7dzZGAfKKyqR0djZN8b8zk8VcnwHXB5HImaQZVSRWeU0jfChsp2tnJMvI4rPO5IetPjszNpIGW/V7VFqcl/SrsSktZ5Mu6EqOASKONqQMqNxLnYwkqevp3rSvuRgn/DeD6O6G3aoyavZgitz4Jl7OwY8EGtEVwc62b3ArVzLKA5IFFLoVB5fJYZlWMKgA+lLTGTiTLuUqSvY05GWTaYNgRFk7ueetDhZGf9Ilsy/m4FOyZWj4W5d9vrUyRRy8I3JG8K7ASV9M0Ka7DkpJdjOm2DXXiuu3Ea7mqrLVBpfIVGlndnZ47AGeAuVXCsDimGV5RuCye+k2QYdwN3XtQTmoLLH00yultj2LxbK2o48sjAde1XkVtZoPUyVtNBx3q8guJouuKvJW1mQ65qsluLChlxxV5AwzJfmhcsDYVNmhlhwKW5miNOD5Yn3UDmPjWNRox8u3NKdhphTk20LY+VutKlYaq6WWtIjES7nQFj0Ldqw3T3Hd0dKistclS4SNxtZQd3oKyKUkdP2otck6DSTNc4RcZ7+lFbqNscsXCiKeS0NHFrGpDFvXiufHU+6zTXOPQ5brhcelF2ySfJ14wvnboKsvd4FpJkljbb2q8OIcYnjNXUPfqCcDPJrq0v7cnH1kF7uMl7TYrMWoVYVzjris05TcsmuuutRwkec12xQSFkbArdRPKOPrKEnwSIIgmCMk1pZgjHDHPFZF5U+ozQ7S/dMJAWfxJsgnoO1TOOCKGeWfXCOMIASScKB3o4tYyKkpZ2rsWuLG4gTfcDZ9auNil0DOqcP1IxaBghlONo75qSabwSEZRW8JPPAYGw/m+tRQZJXKS6J0V/c2rSG2cpvGG46iilXGXZKtRZS24PGRNUkdj1yTnnrRpeEJk/kdsprizmSaNwGXoD3qpwUlhl1XuqW6JiOn5OdIKParyAHjDd6mQJI2avJSg2CbOeKByHxrR1CQRmq3FupFG3TODU3Fe0jssQ3ciqchka8IoWEMbLzS2xsUNPEijhcigbGxTNWaxu/IxSbGbtOk+yzDDAFw3esM5PJ2KKl2wUOzxJGXzCM4H0pc/g21Ln9gn4mJ32+WlbGaFYmN6XKgvEC42nhqz6mOamSfKeD0N+Nq7l6Yrk6N+GZqXzyQ7m6lQ7IkrrwguzV5JOpalJHbyCR9px0rTXSmxVtsYReTz1prLrJsjXexPHvWq3Tp8tmOjXOL2x5Ksmg3N84uJ7hVkA4VR29KRDUQgtkUOv0k7XvlLkw1wungxojM68Fc5p6r38sxTvdScfJPmNzfrkx7fY1ojBR6MUrXb2GgsI4UxlVNRNtkk69uBqc6PZxq80oZzxjNNrk5cMwamtVpSixCfW9MB8iA470z2UIWotSwkKy61bSTxyww7nQgjFU6VhrIyvUzU4ya6PtbuBeQr4WUH6skZNJ09Tg+Tdr9SrcNcEO6t2giUB/K1aE02YmmofhicFrLMfKpIAJzjpjvRZS7F4bX7HRbZbDyAc9at9FJptDkyW8DvtcyQodpcD5jVReUn/AGLshibS5XhiTOEYsVK56Dbzj3qwZLDwOiD2ppgymbWMjtVZC4DoAB1q8inH4Pm2nqQRVNjIxaRwxtjK9KAbEFsO7moNjyWrBVwgNKlIdGtBb5ljoU8jGkR21DwXODgelNSFSSTKMWq74lwetKaNEOjRvFhUN/abnBoHHdwaYtQWTkmslSdmTkdSaX7Jq+qx+kHb6zIhfGcMORmhlQmHXrXHL+Ti33nUgkVftcYKWpbawVbXVUQYL+b1zWWdGWdOvVxUeS0muSzWiqAZG9ueKw/SxhNvBqg65cw7DS3am1zMwVscYPNXXB78JDLtsYZZ5PVmEk5AlMgPrXXri1E81qLM2YyE0nQ5o5EupA4QcgbT0pF2oi/tybNLpJRkrGfoGjWDzCNZHCIRx61xNVqPZi2kdG7UKCyuWC+II9F0cu0simd+dvVjW/033tTBSfCOHqtZCuLlJcniDfTapdSRabCPKCx5xgCu7ZKmiKc2cSqOr1lmKkRr+dUtx4l8xudxDQqvCj60MZuU+I8fI+VGyHMm5eUIRSWUoYXEkob9JxmikpPoKChj7hdIYmmxFOpyeARjNEJb5Kltp8krmL8TDEoUsx2k4AHr0oZTwuglXu6YCP8ApSzxbp7qbzeZcYB9hUaljgGtpyW9GdTucYCWiwoTlATkgDjke9XGL89hP8deBeO5la3kZV2H5WkBwNp7ffFXxnkpbkm0+Oj6G5tItxZDK4GEGOAfU+tExWGA8ZAR4mCoIJAOMmqwMi2h1LYGy/F3QPiyvlWJ/Tj0oYfqwukS/KhlrlmlkNOyYVFBo+wPOaHIbijEnkbB6VYMUfQvHmqyNUcjgnjVcECoC4YNqYZATtHFCw60ffiUjXI7elA4mhMQvL8yetEkDuJUzM7E+9EVnIWGRk+U81TWS1JoL40szAE/TFDtSGb5MMUkCnOaHgZuaRy2t5ppQsUbOx6Ad6jlGKyyoqc3iPZ6a2+FNWEKTS2jeCzDqwz/AK1z5epaZy2KfP8AM21aS3dhobbSFGY7nyKPbGKFXOX6TqTohGP3FTRbvQNNtJFkmTxccGRuv71j1lOqumtq4/BVeopr+2MsD+oa/wDD9xCYFlt7mWUZVYgCVP17Vk02i1kLN0k0l8gfUVSe2LyeL/p9zDqCT/h28DcOgyBXfdsXDbnkyLT2QuU3Hg9fc61Fp1mn4lOXGF5rlVUysm0jtam2NS3Mgza3quoLItixiVf+qnzcemelafp6Kp5s5/BjVt+ohJVrGPg85qh1FGhW9ikzIMhmOS59a6FE62vsZxtTVdFR9yITRRJHdMDcvYQoM3M6jLBPQDux7VNRBThxFSfhf8i67ZUvh7X5Fb6700Oy2OnLtB4lunMsre5/T+wrRUpqK9x5f44X7YMduZ/p4/3/AKib3SOAJLeHHtGB/hTVJPwI9qWeJMxFC0u+e3iKonBYnIBNBJrODRXCW1t+DrWcgUEzBSfmZmOT9v2qPGCKTyMWBgtzL+b+YwC+Iq/KOvH1OOe1Rp+Ck8/a+E+2Lu1zJJkvJIf7O/Jq3x2CqoYxgZTT7ho1C2pCE5O4cn/eTQbkFhLtjDaFKcyRJ4cXYHGapTCljtdHE06JWCTOgz1JHSicnjgCEN0sZwT765B/+vGwaKM8GpBY5GTk/wBPwcMhFHkTGKKOmfnzbSwBxyfahk8LISgpPALV4ntzkZK9jUjLJTrUXwS4pnLYHc0TCSLK2ObcP5ifWsrtxLB01o069wj+IdNyjO4HBrT2czGHg7AJJ22/xVPCCjFyeEbkh52kAEVa5BktrwzkVmJT0/eqbLUWzMllLETiNseoFUpr5C2S+B3TLUO+XIA96XZPC4NGlpU5cle409yoCKDkZFIhbk3X6Zx6M6ZJc6bfRSxWbztn/wDNRyRQ6mMbKmnLAmic65qSWT9R0r4js00o3OqWs9osfzCVRj0zwa8XqNBY7tlUlJv4N9sbJPdjB4j/AOQ9Z02/SJdIdzIW5CdCK9D6Pp9VS2ruhWrmvZUXLMvweVsNGlmdZtQmW1g3AFpXCsw9hXXttcV9scsx1abdza1Ff3PWWk3wbZQLboPxdyThZIIz4n/ka48oep2zb/Svh9f0NTnpYNbH0IfEOl3qqGi1q2jjbkW8tyCwHvtGM1u0Vm//ALbz5eML+WeTPqdZv7swvj/4TdP1mfSJoxdQJdMinwlYl15706/SK2Lintz8Er12IYl93wAm15AlztgYSztuKhtoQ+wHtRw02NqbykX9e1GSiuX+f9hd/iK8lEMZcyLGuMMgJB+tNhpoQy4rszW6q2ajul0LvJfzxM0sUjeOd6lR1A+n+dGlGPQqxym8sxp1rJctKqWcs8iru2AHGPU1c7IV8zeAI1TtWK+wyjz/APLIGROWO3t3o5SWBMYNyWZNmpnkltxLCkdvbsx2xqeaVFpSwzXZBqG9dPwTZlxndITTUjMm/gb0BIru8KXGDGqlsFtob15pOonKMODbo6oWTxPn8fJ6lG0jTrgiMKRwR3xxSob5R+4HVQULMV9GLzXrZgRFgY7AUai0IUFLsh3Ouy5KJnFNUci9iRKuby4nJ5xmixgKKQBYz3OSavJGbuiyGoCjen3ZgnVmzjofpUaysEy48or6pIs9sCoIGO5pcY4YzdlERFApuRb6Kmn6u8CtG0XiBumexpFlCk8nQ03qEqYOOMgTh2Jc8k5pseFgxSeXk2lxDbNvIDEdBmqktyDrs2PJk3gnl3FcknpirSwhU5OUsnotOtor2IqZxGy9AP3rJbZKD6OvpKq74PLwxo6lb6UoilbczLkArnik7JXcmp2w0v2PnJFur2B2d4vy89cDvWmNbSwznStg25R4GNMvJI4ppJnDkABPLnNDOPKUUNhZiM975xwaS91a2lGoWqb/AAsk4jJUCgvqpuTqm+wKZXQ/iQ5/wV9V1fUxp6q9vbRrcYZpBKGABHp+9c/TaKl2/a3x+MHTv19kK19qy1jOcnlmkVGcQ3EKjGGK8k+4rrpSXycacoZ4eEIssT7mNzI2OmY+T+5o0muxb4+TsMYB3wNImeCWYEfYCi/DFt5GILKa5YrEJZOMkgBRVtxQCc30kdlitLWIK7rJJjJ2THcvXgjFApqXOMDJVutLlPPPHgVijDebJA756geo96PoqKbeSnDd3kU9tb21rb/IFUGEHxM92Pc80rdCMXJvgOdNk3CGMPHGB74m0DVdEWO/ndITKAQkLcKD2/8AVY9Lr9Pq5OFa6NNmltqp9xzzjh/ga0TS7UWMeoNrjWzzIVeOBgnHoSc0nVambtdftZwbtFpKtinKbX7NL/kky2NvNfSwabO7xgEFxIWzW6N0oxzPyZJ6OM7ZQrf8whjW2hWAW5DIMcevrk1UU292S7nGEFUo8onXkAPmYYJ7dafFmGUQr6bJ4QCRbTjO5h/lS1dnyaZ6WUY5aFPwxgUhic9c0zKMuMcMCGIbG0c96IHOBhIFcZIo4oz228gZYgvQUTXAEbD0Wi6fZXmmKFZWuDkuvcVydVfZVa//ABPV+m6SjU6fDf3HmJiZWxt/eumjzeQW3wzkjkelWV2VrO5hkhmEwGSmFDdjSbFLKwbNM68S3/AoqeI21ABzTP3MsuHgvaZ8NvcRiQyhRQSsafAMdvbY+NG02xfN/Mp+9Z5Tslwka6nR/wBTI1zp+n3l/tt7kRxsce1N3TjDlclL2p27c4TBavo0ek3CJHdLOGGciqoulastYG6zSrTySUs5F476C0I2iWSbIO9WwB7U2Udxlrm4tnUliv5txS4llyCFDDH3qsbVhB7uVKXI9NDpK3KNNcTJGw88SgHafQUC91Jrj8BudUprGfyV57jS7ezjlsNQSaNF2vEkeyUemc8Y5/istTtcnCyOH854Ndri1GUH0iNNrV3doYIpTHADhkYk5+/etsaYd45MFmpscvubwIppt7cylVi8Q9FOePtUnOMOwqqpXPED02i/AOoXkiNJ4I5BKuxI/iuVqvWaKPDOkvTpVrda0v7iWq6FBo95Lb3ojnkQeVUkIJyTz9q1abV/VQU45SF36aNUfnPXy/5fg4mgTGyku0g2QQFXZXYnOTjpVz1lKmq88sGv07VrE54S+PPAHSNEn1OSQ7lSIDITd1+1MuvVWCtNo/qHn4FJbCODWVS8ykBlHiOMcL9qt2TlU3X2DKiMdQo29eT1tzpOjyxudPtZrmMcLLtO39zXNr1V0X/HaT+DqS0FVkMVRy35MR/C8lpe2txcOTbhxlVz5faq/wBQjbCUIdlw0GyyM284M/GP5skUcl0zwonkjLZC0z06tRg3tw3/AHE+rSw8Rff+5K0Wx0+5vooboBos9Oma2audkK3KrswaKNdtihZ0emvtJsvh2FXtseFIdyknr7VytNqrNU9s+0dl1V6evMVjnB5TVdThlZjvAJ9K69Ve1HE1FynLKOfCkkEmuxPOAyDO3d03Y4pWvU/p2ojvTHF6hbj3OsQq2kurIPISQ2OoP+zXE0U39R33g7+rjuhPPPB+e3M8XQkZr0qR5TgRMkZIxRIW0EEyqOKYmZp15FppSxq2wVDBmK6kt2DROVI6YoJRU1iSNNVsq3ui8MJcOjKDERkVaAwASNmBZyTjsKhX4KenXGn26uL2MyqRjb70uyMpL7WaKLYVt+5HItbAx3A8FGdeo9B96PDwIm4/JeM13cECF7dVC8obpRz+9SOY9ozTVUn2Tbyy1Jw/j2h8LqXU+IAPXIqbh9UF1FiXgQwybZ5GCA8MFKk/waieUNnw9qZsXFvDGrMHebP6m8uPtgg/Sh2vPHRWU/3/ALH0P9Huo28Vr62uC2QECyx4+5DfyaGXup9LH8zRmlx7af8AIw8os98FnMsqt80gUqW9jmi75xgW8eHkVkd92Np596IrJwLvbZ5t2PtirByUIJYLWEYBLj3oWUMQ69c27boYkUjpnnFLnTGa5NNOonU8x/yWNM+LviCaVYoZoU45bwc1ztR6fo2t04/3OpRrdRqJ7HGL/dP/ACS9VTVBevd3glm3EHxShCn/AErVpnp9irhhY8ZEayrUxudlizj8YRW1X4sRLA2dk0TiaNRJ5TxjmsNHp+bPds8ZwdDWepU7FGrl4/oS9HkuZp/yOAeD2yDXRtUcYZy9NKalmHktS6OzSI9zggYAXOf8aRGX2vBpsSlNbz33wvDC1i1uBhMcqK8r6pmFu86Vs8KMoo7qVv8Ah7ZlldWjJx16+lBppt2Jx7NFM1ZLo/LtTkt1uZB4gYZP6smva0puCyjzeu2xteHlCK3KRNuiHNP25XJz1a4yyjN/qE94irNI7hflBbpQQphDLig7dVZats3lCsdksrEsTiicsEhDd2OQWYiG+ByGBz9KU5Z4ZpjTtW6L5Hr/AOINRuLD8HIyhcjLhfMcds0ivRUwt92PY+7X3Sr9t/1PPtGWbNbDAdEJqZJg4y7e9EhbAv1ohbBk1CHWunVdoCr74BNWTYcS5lBDI3T6VRbiP2uoRz+It4gcFT5wACD2PvQyi8LAUXtz5yYIEqhfxkZx2IxRZA2r4OrA6jyPbsP7+DUUmibV8HIpLh5vwrrFECcMWOMfeo5MFUwT5CzixiPhrdzTg44jUeU59T96Fbmh6azjwatLa3uIpGndy+fKD/iTUy84AlLCyEhtPD3CKWEZUghh2qpoumyTz4F5Vt0AVGBPc+9TJbBywYXxElyPSiRXkZ060/EnJbAPX3qmVJ7Ues0rR7DIMwB471mt3+BtGoh5LEul6aYjsii4HXFYXOafZ2qtk+0iVbCC1vSI1T3+lFZunDk1aZxqt4L3xJcW0vw/FkrkA8Vx9BCa1cmadVHZCxy6PzT8HHK+e2e1eqyeTeMnqNCgSIq20ACsdzydPTcIY1fUIl5LjIOMVKa20BqbFF5QnY/GrWEc0aQCUuuAc4xSdV6ZG9pt4Dp9SxFKUc4IepfEuqX+I1lkSM8BEPWtNOiop5S5FX+pai2WIcfsS9koz4g57561sUl4OY4tPkPHHkA0SFtPIzbwq0gBqpdFwWWPSwhQNopGTalg+iwpNCx9bAXqqBxVwAtQoFFMM5x2Cg81ERiU0ozwKYkKkxdmzVgYBsahY5Bot1KAWIRT3YUO9eCNpdjFxpUVocTToZQB+XjAOe9XCW5ZF2TcXjAncmFI9nhqJPVDwaIlak+ciXfhqocVrW3s4og0ytI57Z4qGeUp5xFDcUkD/lixVlY/qq8IpOztsJqVrYQwwNZQOk53GVW+UDtj+aRFW73u68GycqZVrY/u8kvfNyAgGabkU0mVLzTpDZxu2QyKC3Pr2rNCbcmdC+lRqXyJvDGUCqCz1obwYUm3hGX0y5Ee8N5epHtQKxD5aeSWRiCf8HGAQQe3vRdmaUG1ydOrTuT4bkferYMKkjtpeXlzOqNNIEBycGlW4Uc4N2kjKVmM8ANQeUS5SSQD+9Ur5XJeobU/tYukk0hAkmkIHZmJpm2KfCEuyyaxKTaH7ZuuDn2oOCoxyOXF9NBDhW2kjgUCjFs0OU4RIVzcTyNl2Jz3p6wujJLL7OQMQaphQ4LOixxpcb5BuHfPasmob28HX9PjBT3SLGsaXHcWpnhGXUZIHes2nvcZbZHQ9Q0Mba3Ovs8rJIUyvccYrqqWTyso88hbUys27kY/mqlJB11vOS1HJuiG5ecetZ88m9VtxFpGwTir7Aw0KXUuPmNMghF02kKtOoFHgRuFpJS1XgpsCcmiKMmoUYJqEH7m7kdgS5OPU1YhQRy4vVuCWuW3Nt2/t0oFFLo1TtnY1KXYCRonjCqKIX5yEhskMYkc49qsCc2ujgLRsR1HaqYSaa5KFlcYHyiqB2pjZlD5LLzUwU1jo+ARhnbgirwDueDct05TYWyvpQqtLkd9ROSw2LQmPfu70E0adO+RxrqMRsrNjIxmk7Wb90UvuIt9J4821Dwvenw4XJz7WnLCBxKFPPU+lWCuCvpIjSO4YnzbMLmkXJvajfo3GMZNit4yng02BkulkVxuICiibFItaRboJ1EnIwWNItb2s3aWEXYkzWpw7mYkYJ/gdhVV9BarmWSNPFtxnpT0YZIHGAatlRKVm+HwPTmkTRvpm84LdheFCqNyp4xWC2vyd3TanpMnazpZhumlA8jHIFadPepLBz/UNA4T3rpnLdEUDAopSYqutYC/KCBVJjJRwJ3MgSmxWTHbJRJM8hd9x/anxRzpyy8sCTRgI5VFnDVkMtUIDNQgRQztirBwMQ2HiY3A0OS8j8NhGMB6pyKTUmY8NUbaSdoPFUmFKPwaljiK+Uc0wy/f5Axts6VGHFsP43l61QTMG82jHWrBw2Bkut/TiqCUMA1lOcihaGwbQxErTkBhmlvCNEVKbPX6H8OWF3bE3MBLEfMGIIrjaz1C2qaUGek0/punlSnZHLf/AL4PN65psdjeslsz7VPG45rp6a6VtalI43qGlhp7NsOhAuyLlWIrQkYctIEzlveiwA+QtuwDKW9aF9BR4ZUiuRDMsg5wOlLlHKwPhZtluNz3CykkNnPUmpGOC7bFJkm5lBbApiRmbYBX29aIFPAaG6KtxmgccjoWYZRsbkEgkkNnvSLIcHQ096TyUtR1OKSBYwdzVnqoalk6Op1sJVqIrB5iKbIzVfcMtGMd6WmaHBNE+/UAVorOdqYpIjSkbsVpRyWALURDu6oQyWNQhnNQhnvVkKCRGCba4oE0ySi0yjHMBGcDnFWKXYnPcSqwYdPpQ9jUscgfEeQ5PWrwRs0zNt681YLimA3Ed6srBxpT61CKJhmNQJGMnPeoWHh5YdjVMtF3ToMuv1rJdLCZ1dHVukj3mmr4FpnOBivNal77D16gklE8L8QTB7yTn9Vei0cdtSPJ+q2KWoZHUGUlR0HJrZ0ctfcEjiUqh2jBBzQZ5G7VjIN1A+X1ohUkbWX1xV4ByZklz3qYBBE5qyzBGahD5Rg1CkEWRhwDVYCUmGh+bnrQtDYPkq2j8Vnmjo0WIoMw25JpPk37ljJG1O4UHaDkmtVcTkaq1eCNJycmtBzgdEUfCqIfGoQyassyTUIWr87yGbrSaxtvIJZGAwD/ABTDOauDmNBgYoR0uEYQUQsy9QsWlqEMKMmrKGI0XHSoQ0Y1A6VCsgyMNxVF+SxoEzvOI2wQDxWTVRWxnZ9JsbtUGe6mcpYHaegrziX8VHr7JOG5rwj891Q7rlifWvT1LEUjwmrk5WNsFB/wkp77utHLsXD9GTcX/CsPQ0D7HQ/QLZ5I7UaM77Bt1o0LZyrKOioRHKotnDV4BNL1qYLQxEB1oGGux2BiDS5JGqp8h7mVxCxBoYxWTRZZJR4ITsWJLHJNPXBy223lgpOKJAgzREOiqKOnpUIDNWQ4ahZ//9k=');">



    <div class="flex items-end justify-center h-full">
                <form action="" class="max-w-[750px] w-full px-4">
                    <div class="relative">
                        <input type="text" name="q" class="w-full border h-12 shadow p-4 rounded-full" placeholder="search">
                        <button type="submit">
                                <svg class="text-gray-400 h-5 w-5 absolute top-3.5 right-3 fill-current"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                                    x="0px" y="0px" viewBox="0 0 56.966 56.966" style="enable-background:new 0 0 56.966 56.966;"
                                    xml:space="preserve">
                                    <path
                                        d="M55.146,51.887L41.588,37.786c3.486-4.144,5.396-9.358,5.396-14.786c0-12.682-10.318-23-23-23s-23,10.318-23,23  s10.318,23,23,23c4.761,0,9.298-1.436,13.177-4.162l13.661,14.208c0.571,0.593,1.339,0.92,2.162,0.92  c0.779,0,1.518-0.297,2.079-0.837C56.255,54.982,56.293,53.08,55.146,51.887z M23.984,6c9.374,0,17,7.626,17,17s-7.626,17-17,17  s-17-7.626-17-17S14.61,6,23.984,6z" />
                                </svg>
                            </button>
                    </div>
                </form>


            </div>
        </div>


<div class="bg-gray-100">
    <div class="container mx-auto p-6">
        <!-- Header with Background Image and Search Button Centered -->


        <!-- Members Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-6">
            <!-- Member Card Template -->
            <div class="bg-white shadow-lg p-4 rounded-lg w-full">
                <div class="flex flex-col items-center">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSwme89cM8YZvHcybGrZl_Obd9U9p5QabozJQ&s"
                         class="rounded-full mb-2 w-24 h-24 object-cover">
                    <h2 class="font-semibold text-lg">Brian Connor</h2>
                    <p class="text-gray-500 text-sm">Student</p>

                    <!-- Rate Section -->
                    <div class="mt-2 flex items-center gap-1 text-yellow-500">
                        ★★★★☆ <span class="text-gray-600 text-sm">(4.0)</span>
                    </div>

                    <!-- Skills Section -->
                    <div class="mt-3 w-full text-center">
                        <h3 class="text-sm font-semibold text-gray-700">Skills</h3>
                        <div class="flex flex-wrap justify-center gap-2 mt-1">
                            <span class="px-3 py-1 text-xs bg-blue-100 text-blue-600 rounded-full">HTML</span>
                            <span class="px-3 py-1 text-xs bg-green-100 text-green-600 rounded-full">CSS</span>
                            <span class="px-3 py-1 text-xs bg-yellow-100 text-yellow-600 rounded-full">JavaScript</span>
                            <span class="px-3 py-1 text-xs bg-purple-100 text-purple-600 rounded-full">React</span>
                        </div>
                    </div>
                </div>
            </div>



            <div class="bg-white shadow-lg p-4 rounded-lg w-full">
                <div class="flex flex-col items-center">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSwme89cM8YZvHcybGrZl_Obd9U9p5QabozJQ&s"
                         class="rounded-full mb-2 w-24 h-24 object-cover">
                    <h2 class="font-semibold text-lg">Brian Connor</h2>
                    <p class="text-gray-500 text-sm">Student</p>

                    <!-- Rate Section -->
                    <div class="mt-2 flex items-center gap-1 text-yellow-500">
                        ★★★★☆ <span class="text-gray-600 text-sm">(4.0)</span>
                    </div>

                    <!-- Skills Section -->
                    <div class="mt-3 w-full text-center">
                        <h3 class="text-sm font-semibold text-gray-700">Skills</h3>
                        <div class="flex flex-wrap justify-center gap-2 mt-1">
                            <span class="px-3 py-1 text-xs bg-blue-100 text-blue-600 rounded-full">HTML</span>
                            <span class="px-3 py-1 text-xs bg-green-100 text-green-600 rounded-full">CSS</span>
                            <span class="px-3 py-1 text-xs bg-yellow-100 text-yellow-600 rounded-full">JavaScript</span>
                            <span class="px-3 py-1 text-xs bg-purple-100 text-purple-600 rounded-full">React</span>
                        </div>
                    </div>
                </div>
            </div>

            


            <div class="bg-white shadow-lg p-4 rounded-lg w-full">
                <div class="flex flex-col items-center">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSwme89cM8YZvHcybGrZl_Obd9U9p5QabozJQ&s"
                         class="rounded-full mb-2 w-24 h-24 object-cover">
                    <h2 class="font-semibold text-lg">Brian Connor</h2>
                    <p class="text-gray-500 text-sm">Student</p>

                    <!-- Rate Section -->
                    <div class="mt-2 flex items-center gap-1 text-yellow-500">
                        ★★★★☆ <span class="text-gray-600 text-sm">(4.0)</span>
                    </div>

                    <!-- Skills Section -->
                    <div class="mt-3 w-full text-center">
                        <h3 class="text-sm font-semibold text-gray-700">Skills</h3>
                        <div class="flex flex-wrap justify-center gap-2 mt-1">
                            <span class="px-3 py-1 text-xs bg-blue-100 text-blue-600 rounded-full">HTML</span>
                            <span class="px-3 py-1 text-xs bg-green-100 text-green-600 rounded-full">CSS</span>
                            <span class="px-3 py-1 text-xs bg-yellow-100 text-yellow-600 rounded-full">JavaScript</span>
                            <span class="px-3 py-1 text-xs bg-purple-100 text-purple-600 rounded-full">React</span>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Repeat cards for other students -->
            <!-- You can copy and modify the above block to add more members -->
        </div>



    </div>
</div>




  @endsection
