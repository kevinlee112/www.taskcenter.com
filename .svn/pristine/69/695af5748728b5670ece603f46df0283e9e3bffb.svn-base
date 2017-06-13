// Default Form
$(document).ready(function() {
  $('#defaultForm').bootstrapValidator({
    message: 'This value is not valid',
    feedbackIcons: {
      valid: 'fa fa-check',
      invalid: 'fa fa-times',
      validating: 'fa fa-refresh'
    },
    fields: {
      username: {
        message: 'The username is not valid',
        validators: {
          notEmpty: {
            message: 'The username is required and can\'t be empty'
          },
          stringLength: {
            min: 6,
            max: 30,
            message: 'The username must be more than 6 and less than 30 characters long'
          },
          regexp: {
            regexp: /^[a-zA-Z0-9_\.]+$/,
            message: 'The username can only consist of alphabetical, number, dot and underscore'
          }
        }
      },
      country: {
        validators: {
          notEmpty: {
            message: 'The country is required and can\'t be empty'
          }
        }
      },
      acceptTerms: {
        validators: {
          notEmpty: {
            message: 'You have to accept the terms and policies'
          }
        }
      },
      email: {
        validators: {
          notEmpty: {
            message: 'The email address is required and can\'t be empty'
          },
          emailAddress: {
            message: 'The input is not a valid email address'
          }
        }
      },
      website: {
        validators: {
          uri: {
            message: 'The input is not a valid URL'
          }
        }
      },
      phoneNumberUS: {
        validators: {
          phone: {
            message: 'The input is not a valid US phone number'
          }
        }
      },
      phoneNumberUK: {
        validators: {
          phone: {
            message: 'The input is not a valid UK phone number',
            country: 'GB'
          }
        }
      },
      color: {
        validators: {
          hexColor: {
            message: 'The input is not a valid hex color'
          }
        }
      },
      zipCode: {
        validators: {
          zipCode: {
            country: 'US',
            message: 'The input is not a valid US zip code'
          }
        }
      },
      password: {
        validators: {
          notEmpty: {
            message: 'The password is required and can\'t be empty'
          },
          identical: {
            field: 'confirmPassword',
            essage: 'The password and its confirm are not the same'
          }
        }
      },
      confirmPassword: {
        validators: {
          notEmpty: {
            message: 'The confirm password is required and can\'t be empty'
          },
          identical: {
            field: 'password',
            message: 'The password and its confirm are not the same'
          }
        }
      },
      ages: {
        validators: {
          lessThan: {
            value: 100,
            inclusive: true,
            message: 'The ages has to be less than 100'
          },
          greaterThan: {
            value: 10,
            inclusive: false,
            message: 'The ages has to be greater than or equals to 10'
          }
        }
      }
    }
  });
});


// Credit Card
$(document).ready(function() {
  $('#paymentForm').bootstrapValidator({
    feedbackIcons: {
      valid: 'fa fa-check',
      invalid: 'fa fa-times',
      validating: 'fa fa-refresh'
    },
    fields: {
      cardHolder: {
        selector: '#cardHolder',
        validators: {
          notEmpty: {
            message: 'The card holder is required'
          },
          stringCase: {
            message: 'The card holder must contain upper case characters only',
            case: 'upper'
          }
        }
      },
      ccNumber: {
        selector: '#ccNumber',
        validators: {
          notEmpty: {
            message: 'The credit card number is required'
          },
          creditCard: {
            message: 'The credit card number is not valid'
          }
        }
      },
      expMonth: {
        selector: '[data-stripe="exp-month"]',
        validators: {
          notEmpty: {
            message: 'The expiration month is required'
          },
          digits: {
            message: 'The expiration month can contain digits only'
          },
          callback: {
            message: 'Expired',
            callback: function(value, validator) {
              value = parseInt(value, 10);
              var year         = validator.getFieldElements('expYear').val(),
                currentMonth = new Date().getMonth() + 1,
                currentYear  = new Date().getFullYear();
              if (value < 0 || value > 12) {
                return false;
              }
              if (year == '') {
                return true;
              }
              year = parseInt(year, 10);
              if (year > currentYear || (year == currentYear && value > currentMonth)) {
                validator.updateStatus('expYear', 'VALID');
                return true;
              } else {
                return false;
              }
            }
          }
        }
      },
      expYear: {
        selector: '[data-stripe="exp-year"]',
        validators: {
          notEmpty: {
            message: 'The expiration year is required'
          },
          digits: {
            message: 'The expiration year can contain digits only'
          },
          callback: {
            message: 'Expired',
            callback: function(value, validator) {
              value = parseInt(value, 10);
              var month        = validator.getFieldElements('expMonth').val(),
                currentMonth = new Date().getMonth() + 1,
                currentYear  = new Date().getFullYear();
              if (value < currentYear || value > currentYear + 10) {
                return false;
              }
              if (month == '') {
                return false;
              }
              month = parseInt(month, 10);
              if (value > currentYear || (value == currentYear && month > currentMonth)) {
                validator.updateStatus('expMonth', 'VALID');
                return true;
              } else {
                return false;
              }
            }
          }
        }
      },
      cvvNumber: {
        selector: '.cvvNumber',
        validators: {
          notEmpty: {
            message: 'The CVV number is required'
          },
          cvv: {
            message: 'The value is not a valid CVV',
            creditCardField: 'ccNumber'
          }
        }
      }
    }
  });
});

//composer form
$(document).ready(function() {
    $('#composerForm').bootstrapValidator({
        feedbackIcons: {
            valid: 'fa fa-check',
            invalid: 'fa fa-times',
            validating: 'fa fa-refresh'
        },
        fields: {
            en_name: {
                selector: '#en_name',
                validators: {
                    notEmpty: {
                        message: '请输入组件名称'
                    },
                    stringLength: {
                        message: '请输入2-12个字符',
                        min: 2,
                        max:12
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_]+$/,
                        message: '组件名称只能包含大写、小写、数字和下划线'
                    }
                }
            },
            cn_name: {
                selector: '#cn_name',
                validators: {
                    notEmpty: {
                        message: '请输入组件中文名称'
                    },
                    regexp: {
                        regexp: /^([\u4E00-\u9FA5]+，?)+$/,
                        message: '请输入中文'
                    }
                }
            },
            is_show: {
                selector: '#is_show',
                validators: {
                    notEmpty: {
                        message: '请输入是否显示'
                    },
                    regexp: {
                        regexp: /^[Y|N]$/,
                        message: '请输入Y(显示)/N(隐藏)'
                    }
                }
            },
            orderid: {
                selector: '#orderid',
                validators: {
                    notEmpty: {
                        message: '请输入排序ID'
                    },
                    regexp: {
                        regexp: /^[0-9]$/,
                        message: '请输入0-9数字'
                    }
                }
            }
        }
    });
});
// 用户操作
$(document).ready(function() {
    $('#userForm').bootstrapValidator({
        feedbackIcons: {
            valid: 'fa fa-check',
            invalid: 'fa fa-times',
            validating: 'fa fa-refresh'
        },
        fields: {
            username: {
                selector: '#username',
                validators: {
                    notEmpty: {
                        message: '用户名不能为空!!!'
                    },
                }
            },
            password: {
                selector: '#password',
                validators: {
                    notEmpty: {
                        message: '密码不能为空'
                    },
                    stringLength: {
                        min: 8,
                        max: 16,
                        message: '请输入8到16个字符',
                    },
                    regexp: {
                        regexp: /(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\\\|\!\@\#\$\%\^\&\*\(\)\_\+\{\}\[\]\,\.\;\:\/\?\`\~\<\>\'\"\=\-]).{8,16}$/,
                        message: '密码格式错误，请重新输入'
                    }
                }
            },
            realname: {
                selector: '#realname',
                validators: {
                    notEmpty: {
                        message: '真实姓名不能为空'
                    },
                }
            }
        }
    });
});

// 修改密码
$(document).ready(function() {
    $('#passForm').bootstrapValidator({
        feedbackIcons: {
            valid: 'fa fa-check',
            invalid: 'fa fa-times',
            validating: 'fa fa-refresh'
        },
        fields: {
            oldpasswd: {
                selector: '#oldpasswd',
                validators: {
                    notEmpty: {
                        message: '密码不能为空'
                    },
                    stringLength: {
                        min: 8,
                        max: 16,
                        message: '请输入8到16个字符',
                    },
                    regexp: {
                        regexp: /(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\\\|\!\@\#\$\%\^\&\*\(\)\_\+\{\}\[\]\,\.\;\:\/\?\`\~\<\>\'\"\=\-]).{8,16}$/,
                        message: '密码格式错误，请重新输入'
                    }
                }
            },
            newpassword: {
                selector: '#newpasswd',
                validators: {
                    notEmpty: {
                        message: '密码不能为空'
                    },
                    stringLength: {
                        min: 8,
                        max: 16,
                        message: '请输入8到16个字符',
                    },
                    regexp: {
                        regexp: /(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\\\|\!\@\#\$\%\^\&\*\(\)\_\+\{\}\[\]\,\.\;\:\/\?\`\~\<\>\'\"\=\-]).{8,16}$/,
                        message: '密码格式错误，请重新输入'
                    }
                }
            },
            repasswd: {
                selector: '#repasswd',
                validators: {
                    notEmpty: {
                        message: '密码不能为空'
                    },
                    stringLength: {
                        min: 8,
                        max: 16,
                        message: '请输入8到16个字符',
                    },
                    regexp: {
                        regexp: /(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\\\|\!\@\#\$\%\^\&\*\(\)\_\+\{\}\[\]\,\.\;\:\/\?\`\~\<\>\'\"\=\-]).{8,16}$/,
                        message: '密码格式错误，请重新输入'
                    }
                }
            },
        }
    });
});
$(document).ready(function() {
  $('#htmlForm').bootstrapValidator();
});