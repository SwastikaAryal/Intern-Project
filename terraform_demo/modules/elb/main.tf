#creating a load balancer
resource "aws_lb" "my_lb" {
  internal                    = false
  load_balancer_type          = "application"
  security_groups             = [var.security_groups]
  subnets                     = [var.public_subnet1,var.public_subnet2 ]
  enable_deletion_protection  = false
  tags = {
  Name = "alb"
  }
}

#Creating a target group for load balancer
resource "aws_lb_target_group" "my-target-group" {
  
  name                  = "my-tg"
  port                  = 80
  protocol              = "HTTP"
  target_type           = "instance"
  vpc_id                = "${var.vpc_id}"
  health_check {
    interval            = 10
    path                = "/"
    protocol            = "HTTP"
    timeout             = 5
    healthy_threshold   = 3
    unhealthy_threshold = 2
  }
 }

#Creating a listener for ALB
resource "aws_lb_listener" "alb_http_listener" {
  load_balancer_arn   = aws_lb.my_lb.arn
  port                = 80
  protocol            = "HTTP"
  default_action {
    type = "forward"
    target_group_arn  = aws_lb_target_group.my-target-group.arn
  }
}
 