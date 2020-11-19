import { authenticator } from 'otplib'
import { TwoFactorCode } from './TwoFactorCode'

export class TwoFactorKey {
  private readonly key: string

  public constructor(key: string) {
    this.key = key
  }

  public match(code: TwoFactorCode): boolean {
    return authenticator.verify({
      token: code.toString(),
      secret: this.key
    })
  }
}
